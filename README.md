## MorningCoffee
Jeg fandt Morningtrains PHP kode udfordring og har lavet denne løsning, bare
fordi...

**Test output**
```
php -e index.php <file>
```
Eksempel på HTML fil
```
<html>
  <body>
    <h1>
      Bacon ipsum dolor amet brisket burgdoggen ball tip, short ribs biltong flank cupim
    </h1>
    <p>
    Bresaola {name} buffalo, beef ribs strip steak bacon turducken. Cow chislic shankle, bacon burgdoggen ham hock picanha shoulder strip steak bresaola flank cupim pancetta pork belly ball tip. Tri-tip boudin fatback buffalo burgdoggen beef tongue pork chop swine rump prosciutto andouille.
    </p>
    if [[ 1 + 1 = 2]] then
        echo "1 + 1 is 2"
    elif [[ 1 + 1 = 3]] then
        echo "1 + 1 is 3"
    fi
    <p>
    {greeting} {name} {kitty}
    </p>
    <p>
    Fruits=('Apple' 'Banana' 'Orange')
    for Fruits as fruit do
        echo "I eat $fruit"
    done
    </p><p>
    Numbers=(1 2 3)
    for Numbers as number do
        echo "I eat $number"
    done
    </p>
  </body>
</html>
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

### Bash som template sprog
Morningtrains kode udfordring kræver ikke at der er et template sprog, men
hvorfor ikke. Efter at have undersøgt forskellige template syntaks, fik jeg den
idé, at bash ville være ideelt som template sprog :D

Så ideen er, at det er muligt at afvikle en bash-lignende syntaks i HTML koden
```
if [[ 1 + 1 = 2]] then
    echo "1 + 1 = 2"
elif [[ 1 + 1 = 3]] then
    echo "1 + 1 = 3"
fi
```
For at teste ideen lavede jeg [denne
gist](https://gist.github.com/kristiannissen/a5451fe6006f304e9e75446dbb749ed7) med regulære udtryk til at parse koden
med.
