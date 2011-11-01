+++++++++++++++++++++++++++++++++++

++   bdListings

++   Developer:  Mark Hamstra

++   License:    GPL GNU v2

+++++++++++++++++++++++++++++++++++


bdListings bdListings manages your listings


Documentation: 		http://rtfm.modx.com/display/ADDON/bdListings (coming soon)
Bugs & Features: 	https://github.com/DevName/bdListings/issues
Commercial Support:	hello@markhamstra.com

h2. Friendly URLs for categories

If you're looking to use Friendly URLs for categories, you can do so by using rewrite rules in your .htaccess.

You will need a resource which has an *uncached* bdListings snippet call on it that accepts URL parameters (&acceptUrlParams=`1`, on by default). Let's say this resource has ID 40.

We will assume we're looking for an url like this: site.com/listings/category/clowns/ and optionally a subcategory too: site.com/listings/category/clowns/halloween/

For this we'll use these two rewrite rules (above "The Friendly URLs part" in the htaccess shipped with MODX):

    RewriteRule ^listings/category/([^/]+)/([^/]+)/$ index.php?id=40&category=$1&subcategory=$2 [L,QSA]
    RewriteRule ^listings/category/([^/]+)/$ index.php?id=40&category=$1 [L,QSA]

The first rule finds a request that starts with "listings/category/" and has a category after that, followed by a slash, followed by another category name used as subcategory and a closing slash.

The second rule does the same, except that it doesn't look for the subcategory. Both rules rewrite the link to index.php with resource ID 40 and the passed category/subcategories.

Next you will want to create proper links that link to your categories using friendly URLs. Use the bdCategories snippet to create a category list and in the tplCategory chunk, add something along the lines off this:

    <h2><a href="[[++site_url]]listings/category/[[+name:urlencode]]/" title="View all listings in [[+name]]"><h2>
    [[+description:notempty=`<p>[[+description]]</p>`]]

That will (albeit hardcoded) creat the proper links. It's really important to use urlencode there, too.
