const js = require( '@eslint/js' );

module.exports = [
	{
		ignores: [ 'public/partials/js/**/*.min.js', 'admin/js/**/*.min.js' ],
	},
	js.configs.recommended,
	{
		files: [ 'public/partials/js/**/*.js', 'admin/js/**/*.js' ],
		languageOptions: {
			ecmaVersion: 2018,
			sourceType: 'script',
			globals: {
				_da11y: 'readonly',
				console: 'readonly',
				document: 'readonly',
				jQuery: 'readonly',
				MutationObserver: 'readonly',
				setTimeout: 'readonly',
				vendor: 'readonly',
				window: 'readonly',
			},
		},
		rules: {
			'no-extra-semi': 'off',
		},
	},
];
