![WP Pay Portal For Stripe](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/logo.png)

_WP Pay Portal_ offers website designers the possibility to add Stripe subscription services to their Wordpress™ site. Using the portal, end-users may perform various management functions such as pay and download invoices and manage their Stripe subscriptions. 

![Subscriptions](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/subscriptions.png)

The _Wordpress_ plugin is aimed at the end-users of a website, and not Administrators. Administrators are still expected to use the _Stripe_ website to perform advanced management functions.

# Compatibility

_WP Pay Portal_ is a plugin to ![Wordpress™](https://www.wordpress.org) and integrates with ![Stripe™](https://www.stripe.com). The plugin has been tested with _Wordpress V4.8.10_, and may work with other versions. 

# Scope

Presently, the _WP Pay Portal_ plugin does not include mechanisms to control access to digital resources or services based on the status of a subscription within _Stripe_. This aspect is deemed outside the scope of _Wp Pay Portal_ and expected to be handled independently. In other words, another component in your solution ought to enforce the conditions of the subscription via separate connection to the _Stripe API_ or using another third-party solution in accordance with your needs.

Currently, _WP Pay Portal For Stripe_ deals with _Stripe_ subscriptions only, and does not offer a shopping cart or the ability to pay for non subscription related products and services. 

# Installation & Docs

Refer to [Wp Pay Portal For Stripe Wiki](https://github.com/stimulussoft/wppayportal/wiki) for install instructions & docs.

# Features

## Create subscription

Create new Stripe subscriptions by selecting one or more plans and desired quantities. It is possible to define a subset of Stripe plans available for selection. The plugin also supports the possibility to charge an initial fee in the first period.

![New Subscription](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/newsubscription.png)

By default, the new subscription page is accessible to anonymous Wordpress users. The currency is determined using user's IP address (i.e. GeoIP technology) together with currency mappings defined in the plugin configuration.

![Subscribe Process](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/subscribeprocess.png)

![New Subscription](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/newsubscription2.png)

## Manage subscriptions 

View and unsubscribe subscriptions.

![Subscriptions](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/subscriptions.png)

## Create customers and change their details 

![Account Info](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/accountinfo.png)

## View and download invoices

![Invoices](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/invoices.png)

## Set auto pay or manual billing

![Autopay](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/autopay.png)

## Manage billing methods

![Payment Methods](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/paymentmethods.png)

![New card](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/newcard.png)

## Set discount coupon

![Coupon](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/coupon.png)

## View next invoice billing information

View details about the next billing statement.

![Next Invoice](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/nextinvoice.png)

## View usage

View usage in the current period.

## Pay invoices

Pay invoices using loaded credit cards or using a new cards.

![Pay](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/pay.png)

![Pay2](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/pay2.png)

## Login / Register

Login / register Wordpress users using email address and password or email address only. When a user registers, the plugin will verify the user's email address provide a link to submit registration details.

![Register](https://raw.githubusercontent.com/stimulussoft/wppayportal/master/img/registration.png)


## Multi-currency Support

Wp Pay Portal offers support for multiple currencies. 

# Copyright & License

_WP Pay Portal For Stripe_ is Copyright (c) Stimulus Software and licensed under the terms of GPL v3. 

# Disclaimer 

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

WP Pay Portal is no way affliated with Stripe™ or Wordpress™.

# Credits

_Vijayasanthi (developer)_

_Jamie Band (architect & designer)_

The plugin was developed on contract by [Stallioni Net Solutions](https://stallioni.com/). Feel free to contact them should you wish to add functionality to the plugin.  

# Contributions

All contributions to the plugin will be considered and are welcome.



