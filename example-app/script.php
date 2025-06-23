
<?php

$directories = [
    "/var/www/zerowastewagon/example-app/app",
    "/var/www/zerowastewagon/example-app/database",
   "/var/www/zerowastewagon/example-app/resources",
    "/var/www/zerowastewagon/example-app/routes"
];
$outputFile = "output1.txt"; // The output file where the results will be saved

$result = "";

foreach ($directories as $path) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    foreach ($rii as $file) {
        if ($file->isDir()) {
            continue;
        }

        $filename = $file->getPathname();
        $contents = file_get_contents($filename);

        // Prepare the output format: filename followed by its contents
        $result .= "Filename: " . $filename . "\n";
        $result .= "Contents:\n" . $contents . "\n";
        $result .= "----------------------------------------\n";
    }
}

// Write the result to the output file
file_put_contents($outputFile, $result);

echo "Data has been written to $outputFile";

?>
