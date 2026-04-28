const sh = require( 'shelljs' );
const path = require( 'path' );
const AdmZip = require( 'adm-zip' );
const pkg = require( '../package.json' );

const whitelist = [
	'admin',
	'divi-accessibility.php',
	'includes',
	'languages',
	'LICENSE',
	'public',
	'readme.txt',
	'uninstall.php',
];
const package_dir = 'packaged';
const package_file = path.join( package_dir, `${ pkg.name }-${ pkg.version }.zip` );

console.log( `--- Packing ${ pkg.name } v${ pkg.version } ---` );
sh.mkdir( '-p', package_dir );
if ( sh.test( '-e', package_file ) ) {
	console.log( `\t- Removing previously existing archive: ${ package_file }` );
	sh.rm( package_file );
}


console.log( `\t- Packing:` );
const zip = new AdmZip();
sh.ls( '.' ).forEach( raw => {
	if ( whitelist.indexOf( raw ) < 0 ) {
		return true;
	}
	const entry = path.resolve( raw );
		console.log( `\t\tAdding ${ raw }` );
		if ( sh.test( '-d', entry ) ) {
			zip.addLocalFolder(
				entry,
				`${ pkg.name }/${ raw }`,
				( filename ) => path.basename( filename ) !== '.DS_Store'
			);
		} else {
			if ( '.DS_Store' === path.basename( entry ) ) {
				return true;
			}
			zip.addLocalFile( entry, pkg.name );

		}
	} );
console.log( `\t- Writing package archive: ${ package_file }` );
zip.writeZip( package_file );
console.log( `--- All done ---` );
