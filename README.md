![version](https://img.shields.io/badge/version-1.0.0-blue)
![GitHub repo size](https://img.shields.io/github/repo-size/ngdechev/smartbot?color=green)
![Bitbucket open issues](https://img.shields.io/bitbucket/issues/ngdechev/library)

# Real Estate Portal

The project is divided into 3 main folders - **db**, **helpers**, and **public**. 

In the **db** folder, all files related to the connection of the database to the website are stored, including functions for adding, editing, and deleting data. 

The **helpers** folder contains additional functions and constants that help with easier development of the website - constants for the two types of users (client/buyer and broker), sessions, etc.

In the **public** folder, we can find the main files of the website.

The languages used are **PHP**, **SQL**, **HTML**, and **JavaScript**. Most of the website's functionalities are written in **PHP**, **SQL** is used for queries to the database, **HTML** is used for the website's structure, and some small functionalities are written in **JavaScript**.

## Design
The system (website) consists of one database named **db**. It is built from 7 tables:
- users - *store users in the system (site);*
- real_estate_types - *stores property types in the system (site);*
- real_estate_types_of_construction - *stores property construction types;*
- real_estate_level - *stores the completion types of properties on the site;*
- real_estates - *stores information about properties in the system (site);*
- real_estate_user - *stores information about a property that has been added to favorites by a customer / buyer;*
- real_estate_images - *stores the photos of a property.*

### ERD
<p align="center">
  <img src="https://i.ibb.co/Nm6V7TS/Microsoft-Teams-image.png" />
</p>

One user (if they have broker rights) can add many new properties. One property is created by one user - **User:Property = 1:M**

One user, with client rights, can add existing properties to a Favorites list. One property can be present in the Favorites lists of many users - **User:Favorite Property = M:M**

One property can only be of one type (house, apartment, etc.). One type can refer to several properties - **Property Type:Property = 1:M**

One property can only have one type of construction (brick, panel, EPS, etc.). One type can refer to several properties - **Construction Type of Property:Property = 1:M**

One property can only have one completion stage (ACT 16, ACT 14, etc.). One stage can refer to several properties - **Completion Stage of Property:Property = 1:M**

The details of one property can contain several, one or more photos. One photo belongs to the details of one property - **Property:Photo = 1:M**

## Project Development
The following programming languages were used for the development of the project:
1. PHP 
2. SQL 
3. JavaScript

And the following tools:
1. Visual Studio Code
2. XAMPP
3. MySQL

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![SQL](https://img.shields.io/badge/-SQL-yellow?style=for-the-badge) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E) ![Visual Studio Code](https://img.shields.io/badge/Visual%20Studio%20Code-0078d7.svg?style=for-the-badge&logo=visual-studio-code&logoColor=white) ![XAMPP](https://img.shields.io/badge/-XAMPP-orange?style=for-the-badge) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

## A few screenshots from the website
### Home
<p align="center">
  <img src="https://i.ibb.co/G3b7JPX/home.png" />
</p>

### Real Estates
<p align="center">
  <img src="https://i.ibb.co/hHzZ4jv/estates.png" />
</p>

### Brokers
<p align="center">
  <img src="https://i.ibb.co/2hpY9vY/brokers.png" />
</p>

### Search Form
<p align="center">
  <img src="https://i.ibb.co/TYr2xGn/search.png" />
</p>
