<?php 
# This header has to be echoed as plain text generates a parser error
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>

<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/" 
    xmlns:atom="http://www.w3.org/2005/Atom" >

    <channel>
    <atom:link href="<?php echo $feed_url; ?>" rel="self" type="application/rss+xml" />
    
    <title><?php echo $feed_name; ?></title>

    <link><?php echo $feed_url; ?></link>
    <description><?php echo $page_description; ?></description>
    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>

    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />

    <?php foreach($query->result() as $entry): ?>
    
        <item>

          <title><?php echo xml_convert($entry->title); ?></title>
          <link><?php echo site_url('detail/record/' . $entry->id) ?></link>
          <guid><?php echo site_url('detail/record/' . $entry->id	) ?></guid>

          <description><![CDATA[
      		<?php echo $entry -> description; ?>]]>
          </description>
      
      	<?php
			# Format date as RFC822 to be compliant with RSS standards
			# else will fail validation
			# First have to convert to unix timestamp...
			$unix_date = mysql_to_unix($entry -> metadata_created);
			# ...then use gmdate (GMT date) with a formatting string. 
			# For format string details, see gmdate() in the PHP reference
			$rss_date = gmdate('D, d M Y h:m:s T', $unix_date);
	

			$record_date = $rss_date;
		
		?>
      <pubDate><?php echo $record_date;?></pubDate>
        </item>

        
    <?php endforeach; ?>
    
    </channel></rss>  