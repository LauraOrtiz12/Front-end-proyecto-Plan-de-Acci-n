// vite.config.js
import { defineConfig } from "file:///C:/Users/cecia/Desktop/Front-end-proyecto-Plan-de-Acci-n/APP%20V1/plannerapp/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/cecia/Desktop/Front-end-proyecto-Plan-de-Acci-n/APP%20V1/plannerapp/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///C:/Users/cecia/Desktop/Front-end-proyecto-Plan-de-Acci-n/APP%20V1/plannerapp/node_modules/@vitejs/plugin-vue/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: "resources/js/app.js",
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    })
  ],
  resolve: {
    alias: {
      "@images": "/resources/assets/images"
    }
  },
  optimizeDeps: {
    include: ["data-grid-vue"]
    // Asegura que DataGridVue sea incluido en el bundle
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxjZWNpYVxcXFxEZXNrdG9wXFxcXEZyb250LWVuZC1wcm95ZWN0by1QbGFuLWRlLUFjY2ktblxcXFxBUFAgVjFcXFxccGxhbm5lcmFwcFwiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiQzpcXFxcVXNlcnNcXFxcY2VjaWFcXFxcRGVza3RvcFxcXFxGcm9udC1lbmQtcHJveWVjdG8tUGxhbi1kZS1BY2NpLW5cXFxcQVBQIFYxXFxcXHBsYW5uZXJhcHBcXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0M6L1VzZXJzL2NlY2lhL0Rlc2t0b3AvRnJvbnQtZW5kLXByb3llY3RvLVBsYW4tZGUtQWNjaS1uL0FQUCUyMFYxL3BsYW5uZXJhcHAvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogJ3Jlc291cmNlcy9qcy9hcHAuanMnLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgICAgIHZ1ZSh7XG4gICAgICAgICAgICB0ZW1wbGF0ZToge1xuICAgICAgICAgICAgICAgIHRyYW5zZm9ybUFzc2V0VXJsczoge1xuICAgICAgICAgICAgICAgICAgICBiYXNlOiBudWxsLFxuICAgICAgICAgICAgICAgICAgICBpbmNsdWRlQWJzb2x1dGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB9LFxuICAgICAgICB9KSxcbiAgICBdLFxuICAgIHJlc29sdmU6IHtcbiAgICAgICAgYWxpYXM6IHtcbiAgICAgICAgICAgICdAaW1hZ2VzJzogJy9yZXNvdXJjZXMvYXNzZXRzL2ltYWdlcydcbiAgICAgICAgfVxuICAgIH0sXG4gICAgb3B0aW1pemVEZXBzOiB7XG4gICAgICAgIGluY2x1ZGU6IFsnZGF0YS1ncmlkLXZ1ZSddIC8vIEFzZWd1cmEgcXVlIERhdGFHcmlkVnVlIHNlYSBpbmNsdWlkbyBlbiBlbCBidW5kbGVcbiAgICB9XG59KTtcblxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUFnYSxTQUFTLG9CQUFvQjtBQUM3YixPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBRWhCLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLFNBQVM7QUFBQSxJQUNMLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQSxNQUNQLFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxJQUNELElBQUk7QUFBQSxNQUNBLFVBQVU7QUFBQSxRQUNOLG9CQUFvQjtBQUFBLFVBQ2hCLE1BQU07QUFBQSxVQUNOLGlCQUFpQjtBQUFBLFFBQ3JCO0FBQUEsTUFDSjtBQUFBLElBQ0osQ0FBQztBQUFBLEVBQ0w7QUFBQSxFQUNBLFNBQVM7QUFBQSxJQUNMLE9BQU87QUFBQSxNQUNILFdBQVc7QUFBQSxJQUNmO0FBQUEsRUFDSjtBQUFBLEVBQ0EsY0FBYztBQUFBLElBQ1YsU0FBUyxDQUFDLGVBQWU7QUFBQTtBQUFBLEVBQzdCO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
