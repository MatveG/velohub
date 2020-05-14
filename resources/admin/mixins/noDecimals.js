
export const noDecimals = {
  methods: {
      noDecimals(event) {
          event = (event) ? event : window.event;
          let code = (event.which) ? event.which : event.keyCode;

          if (code === 46) {
              event.preventDefault();
          }
      }
  }
};
