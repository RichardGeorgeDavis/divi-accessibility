const compareVersionsPackage = require( 'compare-versions' );
const sh = require( 'shelljs' );
const fs = require( 'fs' );
const rs = require( 'readline-sync' );

const compare = compareVersionsPackage.compareVersions || compareVersionsPackage;

const pkg = require( '../package.json' );
const mainFile = [];
const versionCandidates = {
	package: pkg.version,
};

const assumeYes = !! process.env.npm_config_yes
	|| 'true' === process.env.DA11Y_ASSUME_YES
	|| process.argv.includes( '-y' )
	|| process.argv.includes( '--yes' );
const checkOnly = 'true' === process.env.DA11Y_RELEASE_CHECK
	|| process.argv.includes( '--check' );

const versionRxSrc = '\\d+\\.(?:\\d\.)+\\d(?:(?:-alpha|-beta)-\\d+)?';
const versionRx = new RegExp( versionRxSrc );
const fileHeaderRx = new RegExp( `\\* Version:\\s+(${ versionRxSrc })\\s*$` );
const defineRx = new RegExp(
	`define\\(\\s*[\'"]DA11Y_VERSION\[\'"],\\s*?[\'"](${ versionRxSrc })[\'"]\\s*\\);`
);
const readmeStableTagRx = new RegExp( `^Stable tag:\\s*(${ versionRxSrc })$`, 'm' );
const potProjectVersionRx = new RegExp(
	`Project-Id-Version:\\s+Divi Accessibility (${ versionRxSrc })\\\\n`
);

let finalVersion;
let filesUpdated = false;
let hasErrors = false;
const readmeFile = fs.readFileSync( 'readme.txt', 'utf8' );
const potFile = sh.test( '-e', 'languages/divi-accessibility.pot' )
	? fs.readFileSync( 'languages/divi-accessibility.pot', 'utf8' )
	: null;

fs.readFileSync('divi-accessibility.php', 'utf8').split( /\n/ ).forEach( line => {
	if ( ( line || '' ).match( fileHeaderRx ) ) {
		versionCandidates.fileheader = line.match( fileHeaderRx )[1];
	}
	if ( ( line || '' ).match( defineRx ) ) {
		versionCandidates.define = line.match( defineRx )[1];
	}
	mainFile.push( line );
} );

if ( readmeFile.match( readmeStableTagRx ) ) {
	versionCandidates.readme = readmeFile.match( readmeStableTagRx )[1];
}

if ( potFile && potFile.match( potProjectVersionRx ) ) {
	versionCandidates.pot = potFile.match( potProjectVersionRx )[1];
}

if ( process.env.DA11Y_RELEASE_VERSION || process.env.npm_config_release ) {
	finalVersion = process.env.DA11Y_RELEASE_VERSION || process.env.npm_config_release;
} else {
	finalVersion = Object.values( versionCandidates ).reduce(
		( previous, ver ) => compare( `${ previous }`, `${ ver }` ) >= 0 ? previous : ver,
		'0.0.0'
	);
}

function confirmOrUpdate( prompt, callback ) {
	if ( checkOnly ) {
		return;
	}

	if ( assumeYes ) {
		callback();
		return;
	}

	rs.question( prompt ).match( /y/i ) && callback();
}

function addError( message ) {
	hasErrors = true;
	console.error( `[ERROR] ${ message }` );
}

if ( compare( '' + versionCandidates.package, '' + finalVersion ) !== 0 ) {
	if ( checkOnly ) {
		addError( `Version in package.json (${ pkg.version }) differs from ${ finalVersion }.` );
	} else {
		confirmOrUpdate(
			`\t* Version in package.json (${ pkg.version }) is different. Update? [y/N]`,
			() => {
				filesUpdated = true;
				console.log( `\t- Updating package.json version` );
				pkg.version = finalVersion;
				fs.writeFileSync( 'package.json', JSON.stringify( pkg, null, 2 ) );
			}
		);
	}
}

if (
	compare( '' + versionCandidates.fileheader, '' + finalVersion ) !== 0 ||
	compare( '' + versionCandidates.define, '' + finalVersion ) !== 0
) {
	if ( checkOnly ) {
		addError( `Versions in divi-accessibility.php differ from ${ finalVersion }.` );
	} else {
		confirmOrUpdate(
			`\t* Versions in divi-accessibility.php differ from ${ finalVersion }. Update? [y/N]`,
			() => {
				filesUpdated = true;
				console.log( `\t- Updating main file versions` );
				fs.writeFileSync( 'divi-accessibility.php', mainFile.map( line => {
					if ( ( line || '' ).match( fileHeaderRx ) ) {
						return line.replace( versionRx, finalVersion );
					}
					if ( ( line || '' ).match( defineRx ) ) {
						return line.replace( versionRx, finalVersion );
					}

					return line;

				} ).join( "\n" ) );
			}
		);
	}
}

if ( compare( '' + ( versionCandidates.readme || '0.0.0' ), '' + finalVersion ) !== 0 ) {
	if ( checkOnly ) {
		addError( `Stable tag in readme.txt differs from ${ finalVersion }.` );
	} else {
		confirmOrUpdate(
			`\t* Stable tag in readme.txt differs from ${ finalVersion }. Update? [y/N]`,
			() => {
				filesUpdated = true;
				console.log( `\t- Updating readme.txt stable tag` );
				fs.writeFileSync(
					'readme.txt',
					readmeFile.replace( readmeStableTagRx, `Stable tag: ${ finalVersion }` )
				);
			}
		);
	}
}

if ( potFile && compare( '' + ( versionCandidates.pot || '0.0.0' ), '' + finalVersion ) !== 0 ) {
	if ( checkOnly ) {
		addError( `Project-Id-Version in languages/divi-accessibility.pot differs from ${ finalVersion }.` );
	} else {
		confirmOrUpdate(
			`\t* Project-Id-Version in languages/divi-accessibility.pot differs from ${ finalVersion }. Update? [y/N]`,
			() => {
				filesUpdated = true;
				console.log( `\t- Updating POT metadata` );
				fs.writeFileSync(
					'languages/divi-accessibility.pot',
					potFile.replace(
						potProjectVersionRx,
						`Project-Id-Version: Divi Accessibility ${ finalVersion }\\n`
					)
				);
			}
		);
	}
}

if ( ! sh.grep( `^= ${ finalVersion } =$`, 'readme.txt' ).split( /\n/ )[0] ) {
	addError( `Unable to find changelog entry in readme.txt matching the new version number (${ finalVersion }).` );
}

if ( 'divi-accessibility' !== pkg.name ) {
	addError( `Package name must remain divi-accessibility for release zip naming; found ${ pkg.name }.` );
}

if ( ! fs.readFileSync( 'scripts/package.js', 'utf8' ).includes( '${ pkg.name }-${ pkg.version }.zip' ) ) {
	addError( 'scripts/package.js must continue naming release zips as ${pkg.name}-${pkg.version}.zip.' );
}

if ( ! fs.readFileSync( 'scripts/package.js', 'utf8' ).includes( '${ package_file }.sha256' ) ) {
	addError( 'scripts/package.js must continue writing release checksum assets as ${package_file}.sha256.' );
}

const updaterFile = fs.readFileSync( 'includes/class-divi-accessibility-updater.php', 'utf8' );

if ( ! updaterFile.includes( "'divi-accessibility-' . $version . '.zip'" ) ) {
	addError( 'Updater must continue requiring exact divi-accessibility-{version}.zip release assets.' );
}

if ( ! updaterFile.includes( "'divi-accessibility-' . $version . '.zip.sha256'" ) ) {
	addError( 'Updater must continue requiring exact divi-accessibility-{version}.zip.sha256 release assets.' );
}

if ( filesUpdated ) {
	console.log( `[NOTE] Some files were updated to match your new version number (${ finalVersion }), make sure to commit and tag the changes if needed` );
}

if ( hasErrors ) {
	process.exitCode = 1;
} else if ( checkOnly ) {
	console.log( `[OK] Release metadata is consistent for ${ finalVersion }.` );
}
