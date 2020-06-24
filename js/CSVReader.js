/**
 * @filename CSVReader
 */
import {readFile} from 'fs';

const readCSV = (args) => {
    let filePath = args[0],
        delimiter = args[1],
        data = readFile(filePath, "utf8", (err, data) => {
            if (err) throw err;
            let lines = data.split(/\r?\n/);
            lines.pop();
            lines.map(line => console.log(line.split(delimiter)));
        });
};

export {readCSV};
