# quick_mysqli
Class to connect and query MySQL using MySQLi. Inspired by ezSQL

## get_results(query, index_with, result_format)
- query is your query string
- index_with is the name of the column that will be used as index instead of auto-numeric values in case of OBJECT, ARRAY_A formats
- result_format can be AS_RAW, OBJECT, ARRAY_N, ARRAY_A

### using AS_RAW format

 - you should use this format when you don't need to hold result and run one or more queries, for example a query that collects the data for a csv report, you can query the data in AS_RAW format and then loop through the result set in whichever format you need to process
 - this is the fastest, no extra loops :)

 #### example
 ```
$data = $db->get_results( "SELECT * FROM _users", null, AS_RAW);
while ( $row = @$data->fetch_object() ){
    print_r($row);
}
 ```

though I am fetching as object, you can fetch as any as you want such as fetch_assoc() for associative array or fetch_array() for numeric array indexed

## insert(table_name, data)
- table_name is the name of the table where you want to insert data
- data is an array that holds column names as index and values as values

### using insert()
```
$insertData = array(
    'firstname' => 'Bakkas'
);
$ret = $db->insert('_users', $insertData);
```

return for insert() function will be an array containing either 
