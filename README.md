# 🌍 New Jersey Energy Portal

Project Overview
The New Jersey Energy Portal will be designed to help individuals to understand the energy consumption and energy burdens through the different socio-economic groups. By providing interactive tools like maps and calculators, the users will be able to visualize energy use and make informed decisions about switching to clean energy.

---

## 🔀 Branch Structure

This repo is organized into multiple branches to keep code and data modular and clean:

### `main`
- Contains all **core files**:
  - HTML (e.g. `index.html`, `municipal-map.html`)
  - CSS and JS
  - PHP back-end scripts
- These files power the interactive web portal and load data dynamically.

### `datasets`
- Stores **CSV files** that were used during research or for UI filters:
  - Examples include electricity/natural gas data, tenure, heating types, etc.
  - Some CSVs were referenced but not directly used in the final version.
- This branch helps document data considered during development.

### `geojson-data`
- Contains **local GeoJSON boundary files** for municipalities and counties.
- Some of these were used directly in the portal; others were replaced with external ArcGIS links.
- Useful for backup or offline use.

---

## 🌐 External Data Sources Used

Some map layers are pulled in directly from public GIS services:

- **NJ County Boundaries**
https://maps.nj.gov/arcgis/rest/services/Framework/Government_Boundaries/MapServer/1/query?where=1%3D1&outFields=*&f=geojson

- **NJ Municipal Boundaries**  
https://services2.arcgis.com/XVOqAjTOJ5P6ngMu/arcgis/rest/services/NJ_Municipal_Boundaries_3424/FeatureServer/0/query?outFields=*&where=1%3D1&f=geojson

- **Overburdened Communities (NJDEP)**  
https://services1.arcgis.com/QWdNfRs7lkPq4g4Q/arcgis/rest/services/Overburdened_Communities_under_the_New_Jersey_Environmental_Justice_Law/FeatureServer/19/query?where=1%3D1&outFields=POVUNIVERSE,POPUNDER2XPOV,LOW_INCOME_PCT,TOTALPOP,NONHISPWHITE,TOTALMINORITY,MINORITY_PCT,TOTHH,TOTLANGUAGEISO,PCTLINGUAGEISO,OVERBURDENED_COMMUNITY_CRITERI,BG_TRIBAL,COUNTY,NAME,SPLIT_BG,SPLIT_MUN&outSR=4326&f=geojson

- **OpenStreetMap Tiles**  
  Used as the basemap layer via Leaflet.

---

## 🧪 Running the Project Locally

