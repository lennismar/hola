$("#mobile-nav-filter").hide(),$(function(){$(window).scroll(function(){$(this).scrollTop()>150?$("#mobile-nav-filter").fadeIn():$("#mobile-nav-filter").fadeOut()})}),$("#nav-rrtt").hide(),$(function(){$(window).scroll(function(){$(this).scrollTop()>450?$("#nav-rrtt").fadeIn():$("#nav-rrtt").fadeOut()})}),$("#nav_alt").hide(),$(function(){$(document).on("scroll",function(){var n=$(document).scrollTop();n>100&&3e3>n?$("#nav_alt").fadeIn():$("#nav_alt").fadeOut()})});