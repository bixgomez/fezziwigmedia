AgentPress Child Theme
http://www.studiopress.com/themes/agentpress

INSTALL
1. Upload the AgentPress child theme folder via FTP to your wp-content/themes/ directory. (the Genesis parent theme needs to be in the wp-content/themes/ directory as well)
2. Go to your WordPress dashboard and select Appearance.
3. Activate the AgentPress theme.
4. Inside your WordPress dashboard, go to Genesis > Theme Options and configure them to your liking.

COLOR STYLES
The AgentPress theme comes with 4 additional color stylesheets. To change colors on your site, simply rename one of the colored stylesheets to style.css and upload over the existing one on your server. For instance, if you want to use AgentPress Gray, change gray.css to style.css and place into your AgentPress child theme directory on your server. 

HOMEPAGE SLIDER
1. Inside your WordPress dashboard, go to Genesis > Theme Settings and configure the settings in the "Slider Settings" box. The recommended option for Time Between Slides (in milliseconds) is 6000 and the recommended option for Slide Transition Speed (in milliseconds) is 400.

WIDGETS
Primary Sidebar - This is the primary sidebar if you are using the Content/Sidebar, Sidebar/Content, Content/Sidebar/Sidebar, Sidebar/Sidebar/Content or Sidebar/Content/Sidebar Site Layout option.
Secondary Sidebar - This is the secondary sidebar if you are using the Content/Sidebar/Sidebar, Sidebar/Sidebar/Content or Sidebar/Content/Sidebar Site Layout option.
Featured Properties - This is the featured properties section of the homepage.
Featured Posts - This is the featured posts section of the homepage.
Multi-Agent Page - This is the main content area of the mult-agent page template

THUMBNAILS
By default WordPress will create a default thumbnail image for each image you upload and the size can be specified in your dashboard under Settings > Media. In addition, the AgentPress child theme creates the following thumbnail images you'll see below, which are defined (and can be modified) in the functions.php file. These are the recommended thumbnail sizes that are used on the AgentPress child theme demo site.

Slider - 920px by 300px
Featured Properties - 290px by 200px
Featured Blog - 115px by 115px
Small Thumbnail - 110px by 80px

PROPERTY PHOTO GALLERY
The property listings on the demo site have a property photos section which is utilizing the default image gallery and is using a plugin to display the lightbox effect. The jQuery Lightbox plugin can be found inside the theme’s plugins folder or you can download it at http://wordpress.org/extend/plugins/jquery-lightbox-for-native-galleries. Make sure you upload the plugin via FTP to the wp-content/plugins/ directory on your server and activate it from within the WordPress dashboard. The demo site is currently using the shortcode [gallery size="Small Thumbnail" columns="5" link="file"] inside the post to display the gallery.

SUPPORT
If you are looking for theme support, please visit http://www.studiopress.com/support.