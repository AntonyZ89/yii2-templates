export {};

declare global {
  type Options = {

    /**
     * Message to be displayed in the toast
     *
     * @default "Toastify is awesome!"
     */
    text?: string,

    /**
     * Provide a node to be mounted inside the toast. `node` takes higher precedence over `text`
     *
     * @default undefined
     */
    node?: Node,

    /**
     * Duration for which the toast should be displayed. -1 for permanent toast
     *
     * @default 3000
     */
    duration?: number,

    /**
     * ShadowRoot
     *
     * @default undefined
     */
    selector?: string | HTMLElement,

    /**
     * URL to which the browser should be navigated on click of the toast
     *
     * @default undefined
     */
    destination?: string,

    /**
     * Decides whether the `destination` should be opened in a new window or `not`
     *
     * @default false
     */
    newWindow?: boolean,

    /**
     * To show the close icon or not
     *
     * @default false
     */
    close?: boolean,

    /**
     * To show the toast from top or bottom
     *
     * @default "toastify-top"
     */
    gravity?: 'top' | 'bottom',

    /**
     * To show the toast on left or right
     *
     * @default ''
     */
    position?: 'left' | 'right',

    /**
     * @deprecated use `style.background` option instead. Sets the background color of the toast
     *
     * @default ''
     */
    backgroundColor?: string,

    /**
     * Image/icon to be shown before text
     *
     * @default ''
     */
    avatar?: string,

    /**
     * Ability to provide custom class name for further customization
     *
     * @default ''
     */
    className?: string,

    /**
     * To stop timer when hovered over the toast (Only if duration is set)
     *
     * @default true
     */
    stopOnFocus?: boolean,

    /**
     * Invoked when the toast is dismissed
     *
     * @default function () {}
     */
    callback?: (this: HTMLDivElement) => void,

    /**
     * Invoked when the toast is clicked
     *
     * @default function () {}
     */
    onClick?: () => void,

    /**
     * Ability to add some offset to axis
     *
     * @default {x: 0, y: 0}
     */
    offset?: {
      /**
       * horizontal axis - can be a number or a string indicating unity. eg: '2em'
       *
       * @default 0
       */
      x?: number|string,

      /**
       * vertical axis - can be a number or a string indicating unity. eg: '2em'
       *
       * @default 0
       */
      y?: number|string
    },

    /**
     * Toggle the default behavior of escaping HTML markup
     *
     * @default true
     */
    escapeMarkup?: boolean,

    /**
     * Use the HTML DOM Style properties to add any style directly to toast
     *
     * @default {background: ''}
     */
    style?: CSSStyleDeclaration,

    /**
     * Set the order in which toasts are stacked in page
     *
     * @default true
     */
    oldestFirst?: boolean
  }

  interface Window {
    toastify: {
      success(title: string | null, msg: string | null | Options, extraOptions: Options): void
      info(title: string | null, msg: string | null | Options, extraOptions: Options): void
      warning(title: string | null, msg: string | null | Options, extraOptions: Options): void
      error(title: string | null, msg: string | null | Options, extraOptions: Options): void
    }
  }
}
