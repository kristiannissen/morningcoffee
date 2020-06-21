## MorningCoffee
Jeg fandt Morningtrains PHP kode udfordring og har lavet denne løsning, bare
fordi...

**Test output**
```
php -e index.php <file>
```

### PHP udfordring
> The goal of the PHP challenge, is to create a simple but flexible template parser.
> It must automatically translate an HTML template with placeholders into a HTML string with placeholders replaced by the corresponding values.
> It must be possible to supply an object or array with key-value pairs, where the key indicates the placeholder that must be replaced by the value.
> Consider using regular expressions

### Løsningsforslag
Eksempel på HTML [kan ses
her](https://github.com/kristiannissen/morningcoffee/blob/master/test_file.html)

Key/Value array hvor key erstattes af value i HTML koden
```
$context = [
    'name' => 'Kitty',
    'greeting' => 'Hello',
    'kitty' => function() {
        return 'Whazuup';
    },
];
```
I HTML koden vil {name} blive erstattet af 'Kitty' osv.
