# DSBD Template

<!--toc:start-->
- [DSBD Template](#dsbd-template)
  - [Repository Structure](#repository-structure)
  - [How to use this template](#how-to-use-this-template)
  - [Repository usage](#repository-usage)
    - [setup.sh](#setupsh)
    - [setup-wordpress.sh](#setup-wordpresssh)
    - [wp-plugins.txt](#wp-pluginstxt)
<!--toc:end-->

## Repository Structure
- `bin/`: holds every script used in the project
- `src/`: holds all code related files
  - `src/wordpress/`: mounted in the `wordpress` container.
    - `src/wordpress/wp-content/`: holds all the WordPress files, committed in git
  - `src/plugins`: holds the zip of plugins
  - `ovhconfig`: configure the OVH execution environment like PHP CLI version
- `db/`: holds the local database, and some project backups
- `.github/`: holds the workflows

##  How to use this template

This project is dedicated to create a new WP project. How you should proceed:
- On GitHub, create a new repository based on this template
- Create `.env.local`, `.env.staging`, `.env.production` files
- Fill them with your environment values

Then, on GitHub, you need to create two environments: staging and production.
You can access the environment tab in [https://github.com/<YOUR_GITHUB_USERNAME>/dsbd-template/settings/environments/new](https://github.com/<YOUR_GITHUB_USERNAME>/dsbd-template/settings/environments/new)

The minimal information required is:

**Secrets**
- SSH_SERVER_PASSWORD
- SSH_SERVER_USER
**Environment values**
- SSH_SERVER_URL

These values are used then in `.github/workflows/production.yml` and `.github/workflows/staging.yml`.

Then run `./bin/setup.sh`, follow the script information then all environment should be opened in your browser.

### setup.sh
This script holds all the logic to setup WordPress projects.
It will generate a repository for `local`, `staging` and `production` environments based on the existence of `.env.local`, `.env.staging` and `.env.production` files.

### setup-wordpress.sh

This script holds all the logic to setup WordPress. Documentation can be found within the script itself.

### wp-plugins.txt
Holds all the plugins that should be installed. Works as following:

`[+]my-plugin-name[:version]`

- `my-plugin-name` is the plugin name, mandatory
- `+` means to activate the plugin at installation time, *optional*
- `version` is the plugin version, optional

If you need to reference a `zip` file, do as follow:
- Put the zip in `src/plugins/<myplugin>.zip`
- Specify the path like `/src/plugins/<myplugin>.zip` in wp-plugins.txt like above


## Development

Usually, the only directory that should be committed and changed is `src/wordpress/wp-config/themes/dsdb`. 

Changes to `wp-config.php` should be done via `.env` files and `wp-cli` in the `bin/setup-wordpress.sh` script

Development of feature should be done in a specific branch locally. Once it's done and tested, it should be merged into `main` to be deployed to the `staging` environment.


```sh
# The step belows can also be done via VSCode UI indeed

git switch -c my_feature_branch
# Do code and stuff
git switch main
git merge my_feature_branch
git push origin main
```


Pushing the `main` branch will trigger a build in GitHub, see https://github.com/<yourname>/dsdb-template/actions

Once the code is ready to ship to `production`, do as following:

```sh
git switch production
git merge main
git push origin production
```

It will automatically trigger the deployment to the `production` environment.
