/**
 * @filename CSVReader
 */
import { readFile } from "fs";

const readCSV = (args) => {
  let filePath = args[0],
    delimiter = args[1];
  return new Promise((resolve, reject) => {
    readFile(filePath, "utf8", (err, data) => {
      if (err) return reject(err);
      let lines = data.split(/\r?\n/);
      let table = lines.map((line) => {
        return line.split(delimiter);
      });
      return resolve(table);
    });
  });
};

export { readCSV };
