/**
 * @filename index.js
 * @description This module takes a CSV file_path and CSV delimiter and returns a
 * table showing the content of the file
 * @example node js/index.js file.csv ";"
 */
import CSVReader from "./CSVReader.js";
// Read CLI arguments
const argv = process.argv.slice(2);
let filePath = argv[0],
  csvDelimiter = argv[1] || ",";

CSVReader.readFile(filePath, csvDelimiter).then((data) => console.table(data));
