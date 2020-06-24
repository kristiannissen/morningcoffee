/**
 *
 */
const readCSV = require("./CSVReader");

test('can it read', () => 
    expect(readCSV()).toBe(3);
);
