<?php
// including FileReader
include( 'FileReader.php' );
// including CSVReader

include( 'CSVReader.php' );

// instancing new CSVReader object reading a file 'sample.csv'
$reader =& new CSVReader( new FileReader( 'sample.csv' ) );
// set the separator use format, here a comma
$reader->setSeparator( ',' );

// line tracking
$line = 0;
//  output
echo '<table cellpadding=2 cellspacing=1 bgcolor="#cdcdcd" border=0>';
// while line reading do not return false, otherwise it return an array containing CSV cell.
while( false != ( $cell = $reader->next() ) )
	{
	
	if ( $line == 0 )
	{
		echo "<tr>\n";
		echo	"<td style='font: 11px Verdana;font-weight: bold' nowrap> Index </td>\n";
		for ( $i = 0; $i < count( $cell ); $i++ )
		{
			echo	"<td nowrap style='font: 11px Verdana; font-weight: bold'> Cell n°{$i}</td>\n";
		}
		echo "</tr>\n";		
	}
	echo "<tr>\n";
	echo	"<td bgcolor='".( ( $line % 2 ) == 0 ? '#efefef' : '#ffffff'  )."'>{$line}</td>\n";
	for ( $i = 0; $i < count( $cell ); $i++ )
	{
		echo	"<td bgcolor='".( ( $line % 2 ) ==0 ? '#efefef' : '#ffffff'  )."'>{$cell[$i]}</td>\n";
	}
	echo "</tr>\n";
	$line++;
	}
echo '<table>';
?>