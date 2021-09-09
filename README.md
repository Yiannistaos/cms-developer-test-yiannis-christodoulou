# A CMS Developer Test for agentur-loop by Yiannis Christodoulou

# How to use the Plugin

## STEP 1. Installation
Download, Install & Publish the plugin in your WordPress

## STEP 2. Import Data
Import Data via WP CLI. Open the console and type this command: 
`wp mytest import_sample_data_into_custom_post_type --json_url="https://temp.web357.com/sample-data.json"`

## STEP 3. Show Data
Create a new page and add this shortcode `[mytest-events]`
You can see the events sorted by their timestamps (closest events at the top) on the website. Each event show the time remaining in relative time formats such as "in 20 minutes" or in "5 days".

## STEP 4. Export Data
Navigate to the Admin panel > Settings > Permalinks > Save changes, and then navigate to https://wordpress.test/export-data to see a URL which outputs all events - also sorted by timestamps (closest events at the top) as JSON.

## STEP 5. Estimated and tracked time
We would like you to create a simple list to record the estimated vs. tracked time. You start before you are working on the demo, by splitting it into some smaller chunks and estimate the time for each. Once you are done, record the time it really took you to develop.

| Task                                                                       |      Estimate     |  Tracked time |
|----------------------------------------------------------------------------|:-----------------:|--------------:|
| Create a custom post type                                                  |       30m         |       30m     |
| Create custom fields and save into db                                      |       1h          |       1h      |
| Get data from a json file and import into db via WP CLI                    |       2h          |       3.5h    |
| Cleanup the code, add some comments                                        |       1h          |       1h      |
| Write documentation                                                        |       30m         |       30m     |