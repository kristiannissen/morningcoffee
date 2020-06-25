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
Jeg kunne ikke holde tanken ud, om at jeg havde brugt eval() til denne løsning, og heller ikke den store afhængighed af regulære udtryk... Så jeg skrev en stor del af løsningen om så jeg i stedet for at bruge regulære udtryk, indlæser [hver linje i HTML koden og håndterer den](https://github.com/kristiannissen/morningcoffee/blob/de5118ba7d6199621bb4b1f12a4112eff1b46c7a/src/MorningCoffee/BashParser.php#L24).
### JavaScript udfordring
Med mere tid i overskud valgte jeg også at løse deres JavaScript udfordring

> For the JS challenge, we will be testing your ability to work with node.js and JavaScript in general.
> You are expected to use OOP and the latest language features, as well as demonstrating an understanding of scoping.

Jeg fik så lavet løsningen inden jeg opdagede at det skulle være en OOP baseret løsning og ikke bare et modul der kan løse opgaven. Min første løsning var ellers ret spiffy, synes jeg selv
```
import {readFile} from 'fs';

const readCSV = (args) => {
    let filePath = args[0],
        delimiter = args[1];
  return new Promise((resolve, reject) => {
    readFile(filePath, "utf8", (err, data) => {
      if (err) return reject(err);
      let lines = data.split(/\r?\n/);
      let table = lines.map(line => {
        return line.split(delimiter);
      })
      return resolve(table);
    })
  })
};

export {readCSV};
```
Jeg fandt ud af, at console har en table funktion, så jeg kunne nemt skrive al data ud som table i consollen :)
```
readCSV(argv).then(data => console.table(data));
```
Det hele er ret hurtigt at printe ud. Jeg testede med en fil med MANGE rækker i, og det gik pænt stærkt...

Så blev det til en OOP baseret løsning i stedet, men min løsning opfylder ikke helt forventningerne idet jeg ikke viser jeg kan holde styr på **this** i JS.
```
class CSVReader {
  static readFile(filePath, csvDelimiter) {
    return new Promise((resolve, reject) => {
      readFile(filePath, "utf8", (err, data) => {
        if (err) return reject(err);
        let lines = data.split(/\r?\n/);
        let table = lines.map((line) => {
          return line.split(csvDelimiter);
        });
        return resolve(table);
      });
    });
  }
}
```
Men smukt er det jo... så simpelt!
