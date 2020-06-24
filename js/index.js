/**
 * @filename index.js
 * @description This module takes a CSV file_path and CSV delimiter and returns a
 * table showing the content of the file
 * @example node js/index.js file.csv ";"
 */
import { readCSV } from "./CSVReader.js";
// Read CLI arguments
const argv = process.argv.slice(2);

readCSV(argv).then((data) => console.table(data));
