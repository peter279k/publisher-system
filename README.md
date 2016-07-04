# publisher-system
# Introduction
  This project is inspired by [facebook-anonymous-publisher](https://github.com/kobeengineer/facebook-anonymous-publisher) and it also provide you to easily manage anonymous Facebook page and Plurk bot.
  
  The general method to provide an anonymous Facebook page for people is:
 > An administrator createss a Facebook page and provides a third-party service for people to post messages to a temeporay database. For example, [anonymous monkey] (http://anonymonkey.com/). 
 > When the administrator received a new message from a user, he or she has to manually review and publish the message to the Facebook page.
 > It is not very convenient for us so I develop this project to make them easily manage their Facebook page.
 
### do less Management, do more freedom of publishing the message.

This project provides some advantages by the following steps for you:

+ Without any unprediectable Facebook API errors and this service will automatically publish the message that someone writes.
+ The service will directly publish the new message from users to your Facebook page and you don't have to manually review and publish the message.
+ If someone wants to publish messages, they don't have to use Facebook account to login Facebook. In other words, everyone has the right to publish new message.
+ You can also edit setting file to filter the sensitive words and customize your HTML pages.
+ The service works 24 hours per day and it does not need to sleep.
+ The service supports Facebook and Plurk. In other words, when someone posts message, it will publish the message the Facebook page and Plurk.

## Demonstration
Please visit this link: [bigsu-life](https://peter279k.com/bigsu-life)

## Usage
This application is based on [Slim2](http://docs.slimframework.com/) (a PHP framework) and it's an open source project on Github.

We provide some approaches that can help you to deploy this project. If you don't have your own server, you can see OpenShift section and I will teach you how to build your own service on OpenShift (using "Free plan"). I also provide Heroku section to let you deploy your own service on Heroku (using "Free plan").

If you have your own server, you can see VPS and Shared hosting section.

I hope you will deploy easily and happily enjoy my service!

****Note: if you have any problems, you should create [issue](https://github.com/peter279k/publisher-system/issue) on this project. 

### Step 1: Create a Facebook page
  + [Please click here to create a new Facebook page](https://www.facebook.com/pages/create/), and select appropriate page type, fill in description and other required fields.
  + In your new Facebook page, switch to `About` tab and scroll down to the bottom of the page then note down the `Facebook Page ID`. You will use the role and previlege of this Facebook page to post messages on this page's wall.

### Step 2: Create Facebook App
  + If you are not a Facebook developer, [plrase click here to register as a developer](http://developers.facebook.com) (You have to verify through mobile.)
  + Go to [Facebook Apps dashboard](https://developers.facebook.com/apps) → Click `Add a New App` → Choose platform of `Website`  Choose a name for your application → Click `Create New Facebook App ID` → Choose Category → Click `Create App ID`
  + Go back to [Apps dashboard](https://developers.facebook.com/apps) → Select your new application → `Settings` → `Basic` → Enter `Contact Email` → `Save`
  + Go to `Status & Review` → `Do you want to make this app and all its live features available to the general public?` toggle the button to `Yes` → `Make App Public?`, click `Yes`
  +  Go back to `Dashboard`, note down `App ID` and `App Secret` (You have to click `Show` next to the field; it will ask you to enter your Facebook password.)

### Step 3: Obtain your page access token
  + Go to [Graph API Explorer](https://developers.facebook.com/tools/explorer/) → In the Application drop-down menu, select the name of your app which created in Step 2 → Click `Get Token` to open drop-down menu and select `Get User Access Token` → In Permissions popup menu, checked `manage_pages`, `publish_actions` and `publish_pages` → Click `Get Access Token`

  + Note down the `short-lived token` which shows in the input field next to the Access Token label.

  + Next, we are going to convert short-lived access token to a long-lived token. Please fill in the corresponding values to the following URL and open this URL in a browser:
```
https://graph.facebook.com/oauth/access_token?
  client_id={APP_ID}&
  client_secret={APP_SECRET}&
  fb_exchange_token={SHORTLIVED_ACCESS_TOKEN}&
  grant_type=fb_exchange_token
```

  + You will see `access_token={...}`. This new access_token is the `long-lived token`, next, we are going to use it to get the page access token which will never expire in the future.

  + Go to [Graph API Explorer](https://developers.facebook.com/tools/explorer/) → Paste the `long-lived token` into the Access Token input field → Type `me/accounts` in the `Graph API` query input field → Click `Submit` button → You will see the information of all your pages, find the Facebook page created in Step 1 and note down the `access_token` of it.

  + According to [Facebook's documentation](https://developers.facebook.com/docs/facebook-login/access-tokens#extendingpagetokens), a page access token obtained from long-lived user token will never expire in the future.

## Deployment
  In this section, we will present some approaches about building the service. 
### Step 4: Register an OpenShift account and deploy Publisher Application on it
  + Log in account and go to the applications web console.
  + Click Add Application button and you will see lots of services that can choose.
  + You will see the PHP section and click the see all link. You can look at this picture.
  ![Alt text](https://i.imgur.com/tcw0vv7.png)
  + Drop down the web page and you will find the application named "PHP5.5-cgi-Apache".
  + Click this application and fill the Public URL field then you can click Create Application button.
  + You have to visit the Public URL which you fill. You have to close this web page until the compiling successfully.
  + When compiling successfully, you will see the web page that present the result of executing phpinfo() function.
  + You can visit this link: [Generating a new SSH key](https://help.github.com/articles/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent/#generating-a-new-ssh-key) and refer the "Generating a new SSH key" section.
  + Note! If you use Windows, you have to download [Git for Windows](https://git-scm.com/download/win). It can help you successfully create ssh-key. If you use Unix-based operating system, you will easily generate ssh-key and you can skip the Step5.
### Step5: Generating ssh key
  + This step is for Windows user.
  + Before generating ssh-key, you have already the Git for Windows. If not, you have to go back to step4 and find the download link then install it. When install Git for Windows, using the default settings during installation.
  + Go back to the Windows Desktop and click the right mouse button. You will see the "Git Bash Here" then click it.
  + You will see a bash shell then you can follow the "Generating a new SSH key" step to create key successfully.
  + When creating ssh key successfully, you have to check this folder: ```C:\Users\your-user-name\.ssh```. In this folder, you will find the public key file ```named id_rsa.pub``` and you can use NotePad++ or other edit editors to open it. Note down the public key.
### Step6: Add New key
  + Go back to the OpenShift web console and click Settings tab.
  + Click "Add a new Key..." button and fill the fields. You have to note that you have to paste your public key in the second field.
  + Click create button.
  + Click Applications tab and click your application name which you create.
  + In this web page, you have to see the text: "Source Code". You will find the command: ```ssh://your-user-name@your-public-url/~/git/your-repo-name.git/```. You can refer following picture:
  ![Alt text](https://i.imgur.com/DOExrP5.png)
  + Go back to Desktop. If you use Windows, you can open the git-bash. If you use Unix-based operating system, you have to install Git package. For instance, I use Ubuntu so I open teriminal and input the command: ```sudo apt-get install git-core```
  + Input the command:```git clone ssh://your-user-name@your-public-url/~/git/your-repo-name.git/```.
  + Check out the repo, you have to copy this publisher system repo to "your-repo-name" repo.
  + Check out the file path: /path/to/your-repo-name/.openshift/action_hooks and create the file name: post_deploy.
  + Input the following contents in post_deploy file.
  
  ```bash
  #!/bin/bash
  #Prerequisites
  #Firstly, you have to upload composer.phar via sftp or scp command to the ~/app-root/runtime/bin

  cp ~/app-root/runtime/bin/composer.phar ~/app-root/repo/www/composer.phar

  cd ~/app-root/repo/www

  ~/app-root/runtime/bin/php composer.phar install
  ```
  
  + Open git-bash (Windows) or terminal (Unix-based) and input the command: ```git add .```
  + Input command: ```git commit -a ``` and input the contents: ```Initial commit.```
  + Input the command: ```ssh your-username@your-name-uploadspace.rhcloud.com```
  + Using scp command to copy the composer.phar to this file path: ~/app-root/runtime/bin
  + Input the command: ```git push``` then done.

# Other Information
  If you want to have more informations, please check out the [wiki page](https://github.com/peter279k/publisher-system/wiki). There are many informations about deployment and configuration.
