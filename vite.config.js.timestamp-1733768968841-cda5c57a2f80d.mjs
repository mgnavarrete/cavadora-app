// vite.config.js
import { defineConfig } from "file:///mnt/e/MNT/Personal/Proyectos/[07]-PacienteApp/paciente/node_modules/vite/dist/node/index.js";
import laravel from "file:///mnt/e/MNT/Personal/Proyectos/[07]-PacienteApp/paciente/node_modules/laravel-vite-plugin/dist/index.mjs";
import { viteStaticCopy } from "file:///mnt/e/MNT/Personal/Proyectos/[07]-PacienteApp/paciente/node_modules/vite-plugin-static-copy/dist/index.js";

// package.json
var dependencies = {
  "@popperjs/core": "^2.11.6",
  "@simonwep/pickr": "^1.8.2",
  apexcharts: "^3.41.1",
  bootstrap: "^5.3.2",
  "chart.js": "^3.8.0",
  "choices.js": "^9.0.1",
  "cleave.js": "^1.6.0",
  "datatables.net-bs5": "^1.12.1",
  dragula: "^3.7.3",
  dropzone: "^6.0.0-beta.2",
  echarts: "^5.3.3",
  filepond: "^4.30.4",
  "filepond-plugin-file-encode": "^2.1.10",
  "filepond-plugin-file-validate-size": "^2.2.7",
  "filepond-plugin-file-validate-type": "^1.2.8",
  "filepond-plugin-image-crop": "^2.0.6",
  "filepond-plugin-image-edit": "^1.6.3",
  "filepond-plugin-image-exif-orientation": "^1.0.11",
  "filepond-plugin-image-preview": "^4.6.11",
  "filepond-plugin-image-resize": "^2.0.10",
  "filepond-plugin-image-transform": "^3.8.7",
  flatpickr: "^4.6.13",
  fullcalendar: "^5.11.4",
  glightbox: "^3.2.0",
  gmaps: "^0.4.25",
  gridjs: "^5.1.0",
  jsvectormap: "^1.4.5",
  leaflet: "^1.8.0",
  "masonry-layout": "^4.2.2",
  moment: "2.9.0",
  "node-waves": "^0.7.6",
  nouislider: "^15.6.0",
  "particles.js": "^2.0.0",
  prismjs: "^1.29.0",
  quill: "^1.3.7",
  "rater-js": "^1.0.1",
  simplebar: "^5.3.8",
  "slick-slider": "^1.8.2",
  sweetalert2: "^11.4.19",
  swiper: "^8.4.4",
  wnumb: "^1.2.0"
};

// vite.config.js
import fsExtra from "file:///mnt/e/MNT/Personal/Proyectos/[07]-PacienteApp/paciente/node_modules/fs-extra/lib/index.js";
import { join } from "path";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        // Resources paths
        "resources/css/app.css",
        "resources/sass/app.scss",
        "resources/js/app.js",
        // Resources assets js file paths
        "resources/assets/js/add-products.js",
        "resources/assets/js/alerts.js",
        "resources/assets/js/analytics-dashboard.js",
        "resources/assets/js/apexcharts-area.js",
        "resources/assets/js/apexcharts-bar.js",
        "resources/assets/js/apexcharts-boxplot.js",
        "resources/assets/js/apexcharts-bubble.js",
        "resources/assets/js/apexcharts-candlestick.js",
        "resources/assets/js/apexcharts-column.js",
        "resources/assets/js/apexcharts-heatmap.js",
        "resources/assets/js/apexcharts-line.js",
        "resources/assets/js/apexcharts-mixed.js",
        "resources/assets/js/apexcharts-pie.js",
        "resources/assets/js/apexcharts-polararea.js",
        "resources/assets/js/apexcharts-radar.js",
        "resources/assets/js/apexcharts-radialbar.js",
        "resources/assets/js/apexcharts-rangearea.js",
        "resources/assets/js/apexcharts-scatter.js",
        "resources/assets/js/apexcharts-timeline.js",
        "resources/assets/js/apexcharts-treemap.js",
        "resources/assets/js/authentication.js",
        "resources/assets/js/blog-create.js",
        "resources/assets/js/canada.js",
        "resources/assets/js/cart.js",
        "resources/assets/js/chartjs-charts.js",
        "resources/assets/js/checkout.js",
        "resources/assets/js/choices.js",
        "resources/assets/js/color-picker.js",
        "resources/assets/js/courses-dashboard.js",
        "resources/assets/js/create-invoice.js",
        "resources/assets/js/create-project.js",
        "resources/assets/js/crm-companies.js",
        "resources/assets/js/crm-contacts.js",
        "resources/assets/js/crm-dashboard.js",
        "resources/assets/js/crm-deals.js",
        "resources/assets/js/crm-leads.js",
        "resources/assets/js/crypto-buy_sell.js",
        "resources/assets/js/crypto-currency-exchange.js",
        "resources/assets/js/crypto-dashboard.js",
        "resources/assets/js/crypto-marketcap.js",
        "resources/assets/js/crypto-transactions-list.js",
        "resources/assets/js/custom-switcher.js",
        "resources/assets/js/datatables.js",
        "resources/assets/js/date&time_pickers.js",
        "resources/assets/js/defaultmenu.js",
        "resources/assets/js/draggable-cards.js",
        "resources/assets/js/echarts.js",
        "resources/assets/js/ecommerce-dashboard.js",
        "resources/assets/js/edit-products.js",
        "resources/assets/js/error.js",
        "resources/assets/js/file-manager.js",
        "resources/assets/js/fileupload.js",
        "resources/assets/js/form-input-mask.js",
        "resources/assets/js/fullcalendar.js",
        "resources/assets/js/gallery.js",
        "resources/assets/js/google-maps.js",
        "resources/assets/js/grid.js",
        "resources/assets/js/hrm-dashboard.js",
        "resources/assets/js/invoice-list.js",
        "resources/assets/js/italy.js",
        "resources/assets/js/job-candidate-details.js",
        "resources/assets/js/job-details.js",
        "resources/assets/js/job-search-candidate.js",
        "resources/assets/js/job-search.js",
        "resources/assets/js/jobs-dashboard.js",
        "resources/assets/js/jobs-post.js",
        "resources/assets/js/jsvectormap.js",
        "resources/assets/js/landing.js",
        "resources/assets/js/leaflet.js",
        "resources/assets/js/mail.js",
        "resources/assets/js/mail-settings.js",
        "resources/assets/js/masonry.js",
        "resources/assets/js/modal.js",
        "resources/assets/js/nft-create.js",
        "resources/assets/js/nft-dashboard.js",
        "resources/assets/js/nouislider.js",
        "resources/assets/js/personal-dashboard",
        "resources/assets/js/prism-custom.js",
        "resources/assets/js/product-details.js",
        "resources/assets/js/product-list.js",
        "resources/assets/js/products.js",
        "resources/assets/js/profile.js",
        "resources/assets/js/projects-dashboard.js",
        "resources/assets/js/quill-editor.js",
        "resources/assets/js/ratings.js",
        "resources/assets/js/russia.js",
        "resources/assets/js/sales-dashboard.js",
        "resources/assets/js/select2.js",
        "resources/assets/js/simplebar.js",
        "resources/assets/js/spain.js",
        "resources/assets/js/stocks-dashboard.js",
        "resources/assets/js/sweet-alerts.js",
        "resources/assets/js/swiper.js",
        "resources/assets/js/tabulator.js",
        "resources/assets/js/team.js",
        "resources/assets/js/task-kanban-board.js",
        "resources/assets/js/task-list.js",
        "resources/assets/js/team.js",
        "resources/assets/js/terms_conditions.js",
        "resources/assets/js/Toasts.js",
        "resources/assets/js/todolist.js",
        "resources/assets/js/us-merc-en.js",
        "resources/assets/js/validation.js",
        "resources/assets/js/widgets.js",
        "resources/assets/js/wishlist.js",
        "resources/assets/js/jobs-simplebar.js",
        "resources/assets/js/sales-simplebar.js"
      ],
      refresh: true
    }),
    viteStaticCopy({
      targets: [
        {
          src: [
            "resources/assets/images/",
            "resources/assets/icon-fonts/",
            "resources/assets/video/",
            "resources/assets/js/apex-github-data.js",
            "resources/assets/js/apexcharts-dayjs.js",
            "resources/assets/js/apexcharts-irregulardata.js",
            "resources/assets/js/apexcharts-stock-prices.js",
            "resources/assets/js/apexcharts-candlestick-seriesdata.js",
            "resources/assets/js/authentication-main.js",
            "resources/assets/js/chat.js",
            "resources/assets/js/coming-soon.js",
            "resources/assets/js/dataseries.js",
            "resources/assets/js/main.js",
            "resources/assets/js/show-password.js",
            "resources/assets/js/sticky.js",
            "resources/assets/js/two-step-verification.js",
            "resources/assets/js/under-maintenance.js"
          ],
          dest: "assets/"
        }
      ]
    }),
    {
      // Use a custom plugin for copying distribution files
      name: "copy-dist-files",
      writeBundle: async () => {
        const destDir = "public/build/assets/libs";
        for (const dep of Object.keys(dependencies)) {
          const srcPath = join("node_modules", dep, "dist");
          const destPath = join(destDir, dep);
          if (await fsExtra.pathExists(srcPath)) {
            await fsExtra.copy(srcPath, destPath, {
              overwrite: true,
              recursive: true
            });
            await fsExtra.remove(join(destPath, "dist"));
          } else {
            const packageSrcPath = join("node_modules", dep);
            const packageDestPath = join(destDir, dep);
            if (await fsExtra.pathExists(packageSrcPath)) {
              await fsExtra.copy(packageSrcPath, packageDestPath, {
                overwrite: true,
                recursive: true
              });
            }
          }
        }
      }
    },
    {
      name: "blade",
      handleHotUpdate({ file, server }) {
        if (file.endsWith(".blade.php")) {
          server.ws.send({
            type: "full-reload",
            path: "*"
          });
        }
      }
    }
  ],
  build: {
    chunkSizeWarningLimit: 1600,
    outDir: "public/build",
    emptyOutDir: true
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiLCAicGFja2FnZS5qc29uIl0sCiAgInNvdXJjZXNDb250ZW50IjogWyJjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZGlybmFtZSA9IFwiL21udC9lL01OVC9QZXJzb25hbC9Qcm95ZWN0b3MvWzA3XS1QYWNpZW50ZUFwcC9wYWNpZW50ZVwiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiL21udC9lL01OVC9QZXJzb25hbC9Qcm95ZWN0b3MvWzA3XS1QYWNpZW50ZUFwcC9wYWNpZW50ZS92aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vbW50L2UvTU5UL1BlcnNvbmFsL1Byb3llY3Rvcy9bMDddLVBhY2llbnRlQXBwL3BhY2llbnRlL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB7IHZpdGVTdGF0aWNDb3B5IH0gZnJvbSAndml0ZS1wbHVnaW4tc3RhdGljLWNvcHknO1xuaW1wb3J0ICogYXMgcGFja2FnZXMgZnJvbSAnLi9wYWNrYWdlLmpzb24nO1xuaW1wb3J0IGZzRXh0cmEgZnJvbSAnZnMtZXh0cmEnOyAvLyBJbXBvcnQgZnMtZXh0cmEgYXMgYSBkZWZhdWx0IGltcG9ydFxuaW1wb3J0IHsgam9pbiB9IGZyb20gJ3BhdGgnO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogW1xuXG4gICAgICAgICAgICAgICAgLy8gUmVzb3VyY2VzIHBhdGhzXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsIFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc2Fzcy9hcHAuc2NzcycsIFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwLmpzJyxcblxuICAgICAgICAgICAgICAgIC8vIFJlc291cmNlcyBhc3NldHMganMgZmlsZSBwYXRoc1xuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FkZC1wcm9kdWN0cy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYWxlcnRzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hbmFseXRpY3MtZGFzaGJvYXJkLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLWFyZWEuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtYmFyLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLWJveHBsb3QuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtYnViYmxlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLWNhbmRsZXN0aWNrLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLWNvbHVtbi5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYXBleGNoYXJ0cy1oZWF0bWFwLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLWxpbmUuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtbWl4ZWQuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtcGllLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLXBvbGFyYXJlYS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYXBleGNoYXJ0cy1yYWRhci5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYXBleGNoYXJ0cy1yYWRpYWxiYXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtcmFuZ2VhcmVhLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLXNjYXR0ZXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtdGltZWxpbmUuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtdHJlZW1hcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYXV0aGVudGljYXRpb24uanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2Jsb2ctY3JlYXRlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jYW5hZGEuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2NhcnQuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2NoYXJ0anMtY2hhcnRzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jaGVja291dC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvY2hvaWNlcy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvY29sb3ItcGlja2VyLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jb3Vyc2VzLWRhc2hib2FyZC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvY3JlYXRlLWludm9pY2UuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2NyZWF0ZS1wcm9qZWN0LmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jcm0tY29tcGFuaWVzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jcm0tY29udGFjdHMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2NybS1kYXNoYm9hcmQuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2NybS1kZWFscy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvY3JtLWxlYWRzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jcnlwdG8tYnV5X3NlbGwuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2NyeXB0by1jdXJyZW5jeS1leGNoYW5nZS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvY3J5cHRvLWRhc2hib2FyZC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvY3J5cHRvLW1hcmtldGNhcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvY3J5cHRvLXRyYW5zYWN0aW9ucy1saXN0LmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jdXN0b20tc3dpdGNoZXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2RhdGF0YWJsZXMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2RhdGUmdGltZV9waWNrZXJzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9kZWZhdWx0bWVudS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvZHJhZ2dhYmxlLWNhcmRzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9lY2hhcnRzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9lY29tbWVyY2UtZGFzaGJvYXJkLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9lZGl0LXByb2R1Y3RzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9lcnJvci5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvZmlsZS1tYW5hZ2VyLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9maWxldXBsb2FkLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9mb3JtLWlucHV0LW1hc2suanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2Z1bGxjYWxlbmRhci5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvZ2FsbGVyeS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvZ29vZ2xlLW1hcHMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2dyaWQuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2hybS1kYXNoYm9hcmQuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2ludm9pY2UtbGlzdC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvaXRhbHkuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2pvYi1jYW5kaWRhdGUtZGV0YWlscy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvam9iLWRldGFpbHMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2pvYi1zZWFyY2gtY2FuZGlkYXRlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9qb2Itc2VhcmNoLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9qb2JzLWRhc2hib2FyZC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvam9icy1wb3N0LmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9qc3ZlY3Rvcm1hcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvbGFuZGluZy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvbGVhZmxldC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvbWFpbC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvbWFpbC1zZXR0aW5ncy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvbWFzb25yeS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvbW9kYWwuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL25mdC1jcmVhdGUuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL25mdC1kYXNoYm9hcmQuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL25vdWlzbGlkZXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3BlcnNvbmFsLWRhc2hib2FyZCcsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvcHJpc20tY3VzdG9tLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9wcm9kdWN0LWRldGFpbHMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3Byb2R1Y3QtbGlzdC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvcHJvZHVjdHMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3Byb2ZpbGUuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3Byb2plY3RzLWRhc2hib2FyZC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvcXVpbGwtZWRpdG9yLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9yYXRpbmdzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9ydXNzaWEuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3NhbGVzLWRhc2hib2FyZC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvc2VsZWN0Mi5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvc2ltcGxlYmFyLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9zcGFpbi5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvc3RvY2tzLWRhc2hib2FyZC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvc3dlZXQtYWxlcnRzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9zd2lwZXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3RhYnVsYXRvci5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvdGVhbS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvdGFzay1rYW5iYW4tYm9hcmQuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3Rhc2stbGlzdC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvdGVhbS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvdGVybXNfY29uZGl0aW9ucy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvVG9hc3RzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy90b2RvbGlzdC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvdXMtbWVyYy1lbi5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvdmFsaWRhdGlvbi5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvd2lkZ2V0cy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvd2lzaGxpc3QuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2pvYnMtc2ltcGxlYmFyLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9zYWxlcy1zaW1wbGViYXIuanMnLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgICAgIH0pLFxuXG4gICAgICAgIHZpdGVTdGF0aWNDb3B5KHtcbiAgICAgICAgICAgIHRhcmdldHM6IFtcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNyYzogKFtcbiAgICAgICAgICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2ltYWdlcy8nLCBcbiAgICAgICAgICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2ljb24tZm9udHMvJywgXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy92aWRlby8nLCBcbiAgICAgICAgICAgICAgICAgICAgICAgIFxuICAgICAgICAgICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYXBleC1naXRodWItZGF0YS5qcycsIFxuICAgICAgICAgICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYXBleGNoYXJ0cy1kYXlqcy5qcycsXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hcGV4Y2hhcnRzLWlycmVndWxhcmRhdGEuanMnLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvYXBleGNoYXJ0cy1zdG9jay1wcmljZXMuanMnLCBcbiAgICAgICAgICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL2FwZXhjaGFydHMtY2FuZGxlc3RpY2stc2VyaWVzZGF0YS5qcycsXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9hdXRoZW50aWNhdGlvbi1tYWluLmpzJywgXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jaGF0LmpzJywgXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9jb21pbmctc29vbi5qcycsIFxuICAgICAgICAgICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvanMvZGF0YXNlcmllcy5qcycsXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9tYWluLmpzJywgXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9zaG93LXBhc3N3b3JkLmpzJywgXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy9zdGlja3kuanMnLCBcbiAgICAgICAgICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvYXNzZXRzL2pzL3R3by1zdGVwLXZlcmlmaWNhdGlvbi5qcycsXG4gICAgICAgICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9qcy91bmRlci1tYWludGVuYW5jZS5qcycsXG4gICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnYXNzZXRzLydcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICBdXG4gICAgICAgIH0pLFxuICAgICAgICBcbiAgICAgICAge1xuICAgICAgICAgICAgLy8gVXNlIGEgY3VzdG9tIHBsdWdpbiBmb3IgY29weWluZyBkaXN0cmlidXRpb24gZmlsZXNcbiAgICAgICAgICAgIG5hbWU6ICdjb3B5LWRpc3QtZmlsZXMnLFxuICAgICAgICAgICAgd3JpdGVCdW5kbGU6IGFzeW5jICgpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCBkZXN0RGlyID0gJ3B1YmxpYy9idWlsZC9hc3NldHMvbGlicyc7ICAvLyBVcGRhdGUgdGhlIGRlc3RpbmF0aW9uIGRpcmVjdG9yeVxuICAgICAgXG4gICAgICAgICAgICAgIGZvciAoY29uc3QgZGVwIG9mIE9iamVjdC5rZXlzKHBhY2thZ2VzLmRlcGVuZGVuY2llcykpIHtcbiAgICAgICAgICAgICAgICBjb25zdCBzcmNQYXRoID0gam9pbignbm9kZV9tb2R1bGVzJywgZGVwLCAnZGlzdCcpO1xuICAgICAgICAgICAgICAgIGNvbnN0IGRlc3RQYXRoID0gam9pbihkZXN0RGlyLCBkZXApO1xuICAgICAgXG4gICAgICAgICAgICAgICAgLy8gQ2hlY2sgaWYgdGhlICdkaXN0JyBkaXJlY3RvcnkgZXhpc3RzIGZvciB0aGUgZGVwZW5kZW5jeVxuICAgICAgICAgICAgICAgIGlmIChhd2FpdCBmc0V4dHJhLnBhdGhFeGlzdHMoc3JjUGF0aCkpIHtcbiAgICAgICAgICAgICAgICAgIC8vIENvcHkgdGhlIGRpc3RyaWJ1dGlvbiBmaWxlcyAoY29udGVudHMgb2YgJ2Rpc3QnKSB0byB0aGUgZGVzdGluYXRpb24gZGlyZWN0b3J5XG4gICAgICAgICAgICAgICAgICBhd2FpdCBmc0V4dHJhLmNvcHkoc3JjUGF0aCwgZGVzdFBhdGgsIHtcbiAgICAgICAgICAgICAgICAgICAgb3ZlcndyaXRlOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICByZWN1cnNpdmU6IHRydWUsXG4gICAgICAgICAgICAgICAgICB9KTtcbiAgICAgIFxuICAgICAgICAgICAgICAgICAgLy8gUmVtb3ZlIHRoZSAnZGlzdCcgZGlyZWN0b3J5IGZyb20gdGhlIGRlc3RpbmF0aW9uXG4gICAgICAgICAgICAgICAgICBhd2FpdCBmc0V4dHJhLnJlbW92ZShqb2luKGRlc3RQYXRoLCAnZGlzdCcpKTtcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgLy8gSWYgJ2Rpc3QnIGZvbGRlciBkb2Vzbid0IGV4aXN0LCBjaGVjayBpZiB0aGUgcGFja2FnZSBpdHNlbGYgZXhpc3RzIGFuZCBjb3B5IGl0LlxuICAgICAgICAgICAgICAgICAgY29uc3QgcGFja2FnZVNyY1BhdGggPSBqb2luKCdub2RlX21vZHVsZXMnLCBkZXApO1xuICAgICAgICAgICAgICAgICAgY29uc3QgcGFja2FnZURlc3RQYXRoID0gam9pbihkZXN0RGlyLCBkZXApO1xuICAgICAgXG4gICAgICAgICAgICAgICAgICBpZiAoYXdhaXQgZnNFeHRyYS5wYXRoRXhpc3RzKHBhY2thZ2VTcmNQYXRoKSkge1xuICAgICAgICAgICAgICAgICAgICBhd2FpdCBmc0V4dHJhLmNvcHkocGFja2FnZVNyY1BhdGgsIHBhY2thZ2VEZXN0UGF0aCwge1xuICAgICAgICAgICAgICAgICAgICAgIG92ZXJ3cml0ZTogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICByZWN1cnNpdmU6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSxcbiAgICAgICAgfSxcblxuICAgICAgICB7XG4gICAgICAgICAgICBuYW1lOiAnYmxhZGUnLFxuICAgICAgICAgICAgaGFuZGxlSG90VXBkYXRlKHsgZmlsZSwgc2VydmVyIH0pIHtcbiAgICAgICAgICAgICAgICBpZiAoZmlsZS5lbmRzV2l0aCgnLmJsYWRlLnBocCcpKSB7XG4gICAgICAgICAgICAgICAgICAgIHNlcnZlci53cy5zZW5kKHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6ICdmdWxsLXJlbG9hZCcsXG4gICAgICAgICAgICAgICAgICAgICAgICBwYXRoOiAnKicsXG4gICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0sXG4gICAgICAgIH1cbiAgICBdLFxuICAgIGJ1aWxkOiB7XG4gICAgY2h1bmtTaXplV2FybmluZ0xpbWl0OiAxNjAwLFxuICAgIG91dERpcjogJ3B1YmxpYy9idWlsZCcsXG4gICAgZW1wdHlPdXREaXI6IHRydWUsXG4gIH0sXG59KTtcbiIsICJ7XG4gICAgXCJwcml2YXRlXCI6IHRydWUsXG4gICAgXCJ0eXBlXCI6IFwibW9kdWxlXCIsXG4gICAgXCJzY3JpcHRzXCI6IHtcbiAgICAgICAgXCJkZXZcIjogXCJ2aXRlXCIsXG4gICAgICAgIFwiYnVpbGRcIjogXCJ2aXRlIGJ1aWxkXCJcbiAgICB9LFxuICAgIFwiZGV2RGVwZW5kZW5jaWVzXCI6IHtcbiAgICAgICAgXCJheGlvc1wiOiBcIl4xLjEuMlwiLFxuICAgICAgICBcImNvcHlcIjogXCJeMC4zLjJcIixcbiAgICAgICAgXCJsYXJhdmVsLXZpdGUtcGx1Z2luXCI6IFwiXjAuNy41XCIsXG4gICAgICAgIFwibG9kYXNoXCI6IFwiXjQuMTcuMjFcIixcbiAgICAgICAgXCJwb3N0Y3NzXCI6IFwiXjguNC4yN1wiLFxuICAgICAgICBcInNhc3NcIjogXCJeMS42NS4xXCIsXG4gICAgICAgIFwidml0ZVwiOiBcIl40LjAuMFwiLFxuICAgICAgICBcInZpdGUtcGx1Z2luLXN0YXRpYy1jb3B5XCI6IFwiXjAuMTcuMFwiXG4gICAgfSxcbiAgICBcImRlcGVuZGVuY2llc1wiOiB7XG4gICAgICAgIFwiQHBvcHBlcmpzL2NvcmVcIjogXCJeMi4xMS42XCIsXG4gICAgICAgIFwiQHNpbW9ud2VwL3BpY2tyXCI6IFwiXjEuOC4yXCIsXG4gICAgICAgIFwiYXBleGNoYXJ0c1wiOiBcIl4zLjQxLjFcIixcbiAgICAgICAgXCJib290c3RyYXBcIjogXCJeNS4zLjJcIixcbiAgICAgICAgXCJjaGFydC5qc1wiOiBcIl4zLjguMFwiLFxuICAgICAgICBcImNob2ljZXMuanNcIjogXCJeOS4wLjFcIixcbiAgICAgICAgXCJjbGVhdmUuanNcIjogXCJeMS42LjBcIixcbiAgICAgICAgXCJkYXRhdGFibGVzLm5ldC1iczVcIjogXCJeMS4xMi4xXCIsXG4gICAgICAgIFwiZHJhZ3VsYVwiOiBcIl4zLjcuM1wiLFxuICAgICAgICBcImRyb3B6b25lXCI6IFwiXjYuMC4wLWJldGEuMlwiLFxuICAgICAgICBcImVjaGFydHNcIjogXCJeNS4zLjNcIixcbiAgICAgICAgXCJmaWxlcG9uZFwiOiBcIl40LjMwLjRcIixcbiAgICAgICAgXCJmaWxlcG9uZC1wbHVnaW4tZmlsZS1lbmNvZGVcIjogXCJeMi4xLjEwXCIsXG4gICAgICAgIFwiZmlsZXBvbmQtcGx1Z2luLWZpbGUtdmFsaWRhdGUtc2l6ZVwiOiBcIl4yLjIuN1wiLFxuICAgICAgICBcImZpbGVwb25kLXBsdWdpbi1maWxlLXZhbGlkYXRlLXR5cGVcIjogXCJeMS4yLjhcIixcbiAgICAgICAgXCJmaWxlcG9uZC1wbHVnaW4taW1hZ2UtY3JvcFwiOiBcIl4yLjAuNlwiLFxuICAgICAgICBcImZpbGVwb25kLXBsdWdpbi1pbWFnZS1lZGl0XCI6IFwiXjEuNi4zXCIsXG4gICAgICAgIFwiZmlsZXBvbmQtcGx1Z2luLWltYWdlLWV4aWYtb3JpZW50YXRpb25cIjogXCJeMS4wLjExXCIsXG4gICAgICAgIFwiZmlsZXBvbmQtcGx1Z2luLWltYWdlLXByZXZpZXdcIjogXCJeNC42LjExXCIsXG4gICAgICAgIFwiZmlsZXBvbmQtcGx1Z2luLWltYWdlLXJlc2l6ZVwiOiBcIl4yLjAuMTBcIixcbiAgICAgICAgXCJmaWxlcG9uZC1wbHVnaW4taW1hZ2UtdHJhbnNmb3JtXCI6IFwiXjMuOC43XCIsXG4gICAgICAgIFwiZmxhdHBpY2tyXCI6IFwiXjQuNi4xM1wiLFxuICAgICAgICBcImZ1bGxjYWxlbmRhclwiOiBcIl41LjExLjRcIixcbiAgICAgICAgXCJnbGlnaHRib3hcIjogXCJeMy4yLjBcIixcbiAgICAgICAgXCJnbWFwc1wiOiBcIl4wLjQuMjVcIixcbiAgICAgICAgXCJncmlkanNcIjogXCJeNS4xLjBcIixcbiAgICAgICAgXCJqc3ZlY3Rvcm1hcFwiOiBcIl4xLjQuNVwiLFxuICAgICAgICBcImxlYWZsZXRcIjogXCJeMS44LjBcIixcbiAgICAgICAgXCJtYXNvbnJ5LWxheW91dFwiOiBcIl40LjIuMlwiLFxuICAgICAgICBcIm1vbWVudFwiOiBcIjIuOS4wXCIsXG4gICAgICAgIFwibm9kZS13YXZlc1wiOiBcIl4wLjcuNlwiLFxuICAgICAgICBcIm5vdWlzbGlkZXJcIjogXCJeMTUuNi4wXCIsXG4gICAgICAgIFwicGFydGljbGVzLmpzXCI6IFwiXjIuMC4wXCIsXG4gICAgICAgIFwicHJpc21qc1wiOiBcIl4xLjI5LjBcIixcbiAgICAgICAgXCJxdWlsbFwiOiBcIl4xLjMuN1wiLFxuICAgICAgICBcInJhdGVyLWpzXCI6IFwiXjEuMC4xXCIsXG4gICAgICAgIFwic2ltcGxlYmFyXCI6IFwiXjUuMy44XCIsXG4gICAgICAgIFwic2xpY2stc2xpZGVyXCI6IFwiXjEuOC4yXCIsXG4gICAgICAgIFwic3dlZXRhbGVydDJcIjogXCJeMTEuNC4xOVwiLFxuICAgICAgICBcInN3aXBlclwiOiBcIl44LjQuNFwiLFxuICAgICAgICBcIndudW1iXCI6IFwiXjEuMi4wXCJcbiAgICB9XG59XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQXVWLFNBQVMsb0JBQW9CO0FBQ3BYLE9BQU8sYUFBYTtBQUNwQixTQUFTLHNCQUFzQjs7O0FDZTNCLG1CQUFnQjtBQUFBLEVBQ1osa0JBQWtCO0FBQUEsRUFDbEIsbUJBQW1CO0FBQUEsRUFDbkIsWUFBYztBQUFBLEVBQ2QsV0FBYTtBQUFBLEVBQ2IsWUFBWTtBQUFBLEVBQ1osY0FBYztBQUFBLEVBQ2QsYUFBYTtBQUFBLEVBQ2Isc0JBQXNCO0FBQUEsRUFDdEIsU0FBVztBQUFBLEVBQ1gsVUFBWTtBQUFBLEVBQ1osU0FBVztBQUFBLEVBQ1gsVUFBWTtBQUFBLEVBQ1osK0JBQStCO0FBQUEsRUFDL0Isc0NBQXNDO0FBQUEsRUFDdEMsc0NBQXNDO0FBQUEsRUFDdEMsOEJBQThCO0FBQUEsRUFDOUIsOEJBQThCO0FBQUEsRUFDOUIsMENBQTBDO0FBQUEsRUFDMUMsaUNBQWlDO0FBQUEsRUFDakMsZ0NBQWdDO0FBQUEsRUFDaEMsbUNBQW1DO0FBQUEsRUFDbkMsV0FBYTtBQUFBLEVBQ2IsY0FBZ0I7QUFBQSxFQUNoQixXQUFhO0FBQUEsRUFDYixPQUFTO0FBQUEsRUFDVCxRQUFVO0FBQUEsRUFDVixhQUFlO0FBQUEsRUFDZixTQUFXO0FBQUEsRUFDWCxrQkFBa0I7QUFBQSxFQUNsQixRQUFVO0FBQUEsRUFDVixjQUFjO0FBQUEsRUFDZCxZQUFjO0FBQUEsRUFDZCxnQkFBZ0I7QUFBQSxFQUNoQixTQUFXO0FBQUEsRUFDWCxPQUFTO0FBQUEsRUFDVCxZQUFZO0FBQUEsRUFDWixXQUFhO0FBQUEsRUFDYixnQkFBZ0I7QUFBQSxFQUNoQixhQUFlO0FBQUEsRUFDZixRQUFVO0FBQUEsRUFDVixPQUFTO0FBQ2I7OztBRHZESixPQUFPLGFBQWE7QUFDcEIsU0FBUyxZQUFZO0FBRXJCLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLFNBQVM7QUFBQSxJQUNMLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQTtBQUFBLFFBR0g7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBO0FBQUEsUUFHQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7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
