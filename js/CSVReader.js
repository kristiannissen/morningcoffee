/**
 * @filename CSVReader
 */
import { readFile } from "fs";

class CSVReader {
  /**
   * Represents a CSV Reader
   * @constructor
   * @param {string} filePath - The path to the CSV file
   * @param {string} csvDelimiter - Either "," or ";" can be used
   */
  constructor(filePath, csvDelimiter) {
    this.filePath = filePath;
    this.csvDelimiter = csvDelimiter;
  }
  /**
   * Reads the CSV file and returns the data set using the delimiter
   * @return {promise} - Returns the data set using a promise
   */
  readFile() {
    return new Promise((resolve, reject) => {
      readFile(this.filePath, "utf8", (err, data) => {
        if (err) return reject(err);
        let lines = data.split(/\r?\n/);
        let table = lines.map((line) => {
          return line.split(this.csvDelimiter);
        });
        return resolve(table);
      });
    });
  }
}

export default CSVReader;
