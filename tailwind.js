module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
  	 boxShadow: {
        default: '0 0 5px 0 rgba(0, 0, 0, 0.08)', 
        md: '0 4px 8px 0 rgba(0, 0, 0, 0.12), 0 2px 4px 0 rgba(0, 0, 0, 0.08)',
        lg: '0 15px 30px 0 rgba(0, 0, 0, 0.11), 0 5px 15px 0 rgba(0, 0, 0, 0.08)',
        inner: 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
        outline: '0 0 0 3px rgba(52, 144, 220, 0.5)',
        none: 'none',
      },
   colors: {
        'grey-light':'#F5F6F9',
        'white':'#fff',
        'grey':'rgba(0, 0, 0, 0.4)',
        'blue': '#007ace',
        'blue-light': '#8ae2fe',
        'red':'#e60000'
      },
    extend: {
      //fontFamily:{
      //  sans:['Open Sans']
      //},
      //lineHeight: {
      //none: 1,
      //tight: 1.25,
      //normal: 1.5,
      //loose: '40px'
    //}
    },
  },
  variants: {},
  plugins: [],
}
