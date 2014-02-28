<?php 
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
    
    <title><?php echo $feed_name; ?></title>

    <link><?php echo $feed_url; ?></link>
	<atom:link href="<?= $feed_url; ?>" rel="self" type="application/rss+xml" />
	<lastBuildDate><?= rss_date($build_date); ?></lastBuildDate>
    <dc:subject><?php echo $feed_subject; ?></dc:subject>
    <description><?php echo $feed_description; ?></description>
    <dc:language><?php echo $feed_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>

    <dc:rights>Creative Commons by-nc-sa</dc:rights>
    <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />

    <?php foreach($posts -> result() as $entry): ?>
    
        <item>

          <title><?php echo xml_convert($entry -> title); ?></title>
          <link><?php echo site_url('news/article/' . $entry -> id) ?></link>
          <guid><?php echo site_url('news/article/' . $entry -> id) ?></guid>

        <description><![CDATA[
			<?= $entry -> text; ?>
			]]>
		</description>

      <pubDate><?= rss_date($entry -> posted); ?></pubDate>
        </item>

        
    <?php endforeach; ?>
    
    </channel></rss>  
	
	<?php 
	/**
	* Convert a MySQL date string into a RSS-compliant date
	* @param str $mysql_date Date in MySQL internal format, eg 2013-04-05 21:56:47
	* @return str Date in RSS-compliant RFC 822 format
	*/
	function rss_date($mysql_date)
	{
		# Format date as RFC822 to be compliant with RSS standards
		# else will fail validation
		# First have to convert to unix timestamp...
		$unix_date = mysql_to_unix($mysql_date);
		# ...then use standard_date() from CI date helper to output a RFC822 date
		return standard_date('DATE_RFC822', $unix_date);
	
	}