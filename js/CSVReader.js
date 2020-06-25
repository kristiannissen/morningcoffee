/**
 * @filename CSVReader
 */
import { readFile } from "fs";

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

export default CSVReader;
