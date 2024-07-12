import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    '50': "#f2ffe5",
                    '100': "#dfffc7",
                    '200': "#c1ff95",
                    '300': "#98fe58",
                    '400': "#73f526",
                    '500': "#52dc06",
                    'default': "#39a900",
                    '700': "#2e8506",
                    '800': "#29690b",
                    '900': "#24580f",
                    '950': "#0e3201",
                },
                secondary: {
                    '50': "#eff9ff",
                    '100': "#def3ff",
                    '200': "#b6e9ff",
                    '300': "#75daff",
                    '400': "#2cc8ff",
                    '500': "#01b1f6",
                    '600': "#008ed3",
                    '700': "#0071ab",
                    '800': "#005f8d",
                    '900': "#064f74",
                    'default': "#04324d",
                },
                tertiary: {
                    '50': '#edfcfe',
                    '100': '#d3f5fa',
                    '200': '#acebf5',
                    'default': '#82def0',
                    '400': '#31c0df',
                    '500': '#15a3c5',
                    '600': '#1582a5',
                    '700': '#186986',
                    '800': '#1c566e',
                    '900': '#1c485d',
                    '950': '#0c2f40',
                },
                alternate: {
                    'default': '#fbfbe2',
                    '100': '#f9f9c8',
                    '200': '#f4f194',
                    '300': '#ede357',
                    '400': '#e6d129',
                    '500': '#d6ba1c',
                    '600': '#b99315',
                    '700': '#946c14',
                    '800': '#7b5518',
                    '900': '#69461a',
                    '950': '#3d260b',
                },
                completary:{
                    '50': '#f5f8f8',
                    '100': '#ddeae6',
                    '200': '#bad5cf',
                    '300': '#90b8b0',
                    '400': '#689991',
                    '500': '#4e7e77',
                    'default': '#385c57',
                    '700': '#34514e',
                    '800': '#2c4340',
                    '900': '#283937',
                    '950': '#13201e',
                },
                completaryalternate:{
                    '50': '#fcf5f4',
                    '100': '#f8ebe8',
                    '200': '#f3dad5',
                    '300': '#eac0b7',
                    '400': '#dc9a8d',
                    'default': '#cb7766',
                    '600': '#b65e4c',
                    '700': '#984c3d',
                    '800': '#7f4135',
                    '900': '#6b3b31',
                    '950': '#391c16',
                },
            },
        },
    },

    plugins: [forms, typography],
};
