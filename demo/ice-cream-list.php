<?php
/**
 * ice-cream-list.php along with ice-cream-view.php creates a list/view application
 * 
 * @package SM16
 * @author Caress Roche <croche02@seattlecentral.edu>
 * @version 0.1 2016/07/13
 * @link http://www.caressroche.com/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see ice-cream-view.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql = "select * from sm16_iceCream";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'Ice cream made with love & PHP in Seattle';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC280 Class Muffins are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'Muffins,PHP,Fun,Bran,Regular,Regular Expressions,'. $config->metaKeywords;

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center">Ice cream</h3>

<p>This page, along with <b>ice-cream-view.php</b>, demonstrate a List/View web application.</p>
<p>It was built on the mysql shared web application page, <b>demo_shared.php</b></p>
<p>This page is the entry point of the application, meaning this page gets a link on your web site.  Since the current subject is muffins, we could name the link something clever like <a href="<?php echo VIRTUAL_PATH; ?>ice-cream-list.php">Muffins</a></p>
<p>Use <b>ice-cream-list.php</b> and <b>ice-cream-view.php</b> as a starting point for building your own List/View web application!</p> 
<?php
#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

# Create instance of new 'pager' class
$myPager = new Pager(2,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "ice cream";}else{$itemz = "ice cream";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
	while($row = mysqli_fetch_assoc($result))
	{# process each row
         echo '<div align="center"><a href="' . VIRTUAL_PATH . 'demo/ice-cream-view.php?id=' . (int)$row['IceCreamID'] . '">' . dbOut($row['Flavor']) . '</a>';
         echo ' <i>only</i> <font color="red">' . number_format((int)$row['Calories'])  . '</font> calories!</div>';
	}
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>What! No ice cream?  There must be a mistake!!</div>";	
}
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
