<?php
ini_set('memory_limit','5G');
$dirchr=dirname('/');
$drive = readline("Enter drive path(ending with ".$dirchr."): ");
readline_add_history($drive);
$maxbuff=readline("Enter buffersize in MB: ");
readline_add_history($maxbuff);
echo "Creating buffer...".chr(13).chr(10);
$buffer=str_repeat("!",1024*1024*$maxbuff);
$n=0;
echo "Writing to flash drive";
if(!is_dir($drive."flashtest.dir"))mkdir($drive."flashtest.dir");
try {
while(disk_free_space($drive."flashtest.dir")>$maxbuff*1024*1024){
$n++;
$datafile=fopen($drive."flashtest.dir".$dirchr.$n.".test","w");
fwrite($datafile,$buffer);fclose($datafile);echo ".";
} 
} catch (Exception $e) {
    echo 'Done writting! '.$e->getMessage().chr(13).chr(10);
}
if(is_file($drive."flashtest.dir".$dirchr.$n.".test"))
unlink($drive."flashtest.dir".$dirchr.$n.".test");
echo chr(13).chr(10)."Verifying Files...".chr(13).chr(10);
$md5old="none";
$hashcount=0;
$verified=array();
foreach (glob($drive."flashtest.dir".$dirchr."*.test") as $filename) {
echo "Testing ".$filename.chr(13).chr(10);
$md5new=md5_file($filename);
    if($md5old!=$md5new){
$md5old=$md5new;
$hashcount++;
echo $md5new.chr(13).chr(10);
}
$verified[$md5new]++;
}
echo chr(13).chr(10);
if($hashcount==1){
echo "This drive is not fake".chr(13).chr(10);}else{
echo "This drive is fake".chr(13).chr(10);
echo "It appears to be a ".number_format(($verified[md5($buffer)]*1024*1024*$maxbuff)/(1024*1024))."MB flash drive".chr(13).chr(10);
}
readline_add_history(readline("Press enter to remove test files.."));
echo "Removing .test files...".chr(13).chr(10);
for($i=1;$i<$n;$i++)if(is_file($drive."flashtest.dir".$dirchr.$i.".test"))
unlink($drive."flashtest.dir".$dirchr.$i.".test");
?>