const fs = require( 'fs' );
const postcss = require( 'postcss' );
const sh = require( 'shelljs' );

let hasErrors = false;

sh.ls( 'public/partials/css/*.css' ).forEach( ( input ) => {
	const source = fs.readFileSync( input, 'utf8' );

	try {
		postcss.parse( source, { from: input } );
	} catch ( error ) {
		hasErrors = true;
		console.error( `${ input }:${ error.line || 1 }:${ error.column || 1 } ${ error.reason }` );
	}
} );

if ( hasErrors ) {
	process.exit( 1 );
}
