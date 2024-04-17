# DSBD Template

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

## Repository usage

**TL;DR**: Create `.env.{local,staging,production}`, then run `./setup.sh` 

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

```sh
# Editer wp-plugins.txt
vscode wp-plugins.txt

./setup.sh
```


