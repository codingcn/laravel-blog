webpackJsonp([9],{

/***/ 212:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(254)
}
var normalizeComponent = __webpack_require__(76)
/* script */
var __vue_script__ = __webpack_require__(256)
/* template */
var __vue_template__ = __webpack_require__(257)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources\\assets\\admin\\js\\components\\page\\Articles.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-loader/node_modules/vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2a1c6ab6", Component.options)
  } else {
    hotAPI.reload("data-v-2a1c6ab6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 217:
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(218)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ 218:
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),

/***/ 254:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(255);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(217)("538da298", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/_css-loader@0.28.9@css-loader/index.js!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-2a1c6ab6\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/selector.js?type=styles&index=0!./Articles.vue", function() {
     var newContent = require("!!../../../../../../node_modules/_css-loader@0.28.9@css-loader/index.js!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-2a1c6ab6\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/selector.js?type=styles&index=0!./Articles.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 255:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(98)(false);
// imports


// module
exports.push([module.i, "\n.el-tag {\n    margin-right: 0.8rem;\n}\n.demo-table-expand {\n    font-size: 0;\n}\n.demo-table-expand label {\n    width: 90px;\n    color: #99a9bf;\n}\n.demo-table-expand .el-form-item {\n    margin-right: 0;\n    margin-bottom: 0;\n    width: 50%;\n}\n", ""]);

// exports


/***/ }),

/***/ 256:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        this.getArticles();
    },
    data: function data() {
        return {
            loading: false,
            tableData: [],
            page: {}
        };
    },

    methods: {
        currentChange: function currentChange(p) {
            var _this = this;

            this.loading = true;
            this.$axios({
                url: this.$difines.root_url + '/api/admin/articles?page=' + p,
                method: 'get',
                headers: {
                    'Authorization': 'Bearer ' + this.$auth.getToken()
                }
            }).then(function (response) {
                _this.tableData = response.data.data.data;
                _this.page.pageSize = response.data.data.per_page;
                _this.page.total = response.data.data.total;
                _this.loading = false;
            }).catch(function (response) {});
        },
        getArticles: function getArticles() {
            var _this2 = this;

            this.loading = true;
            this.$axios({
                url: this.$difines.root_url + '/api/admin/articles',
                method: 'get',
                headers: {
                    'Authorization': 'Bearer ' + this.$auth.getToken()
                }
            }).then(function (response) {
                _this2.tableData = response.data.data.data;
                _this2.page.pageSize = response.data.data.per_page;
                _this2.page.total = response.data.data.total;
                _this2.loading = false;
            }).catch(function (response) {
                console.log(response);
                _this2.loading = false;
            });
        },
        handleEdit: function handleEdit(index, row) {
            this.$router.push({ name: 'articles/edit', params: { id: row.id } });
        },
        handleDelete: function handleDelete(index, row) {
            var _this3 = this;

            this.$axios({
                url: this.$difines.root_url + '/api/admin/articles/' + row.id,
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + this.$auth.getToken()
                }
            }).then(function (response) {
                if (response.data.err_no == 0) {
                    _this3.$notify.success({
                        title: '成功',
                        message: '文章删除成功'
                    });
                    _this3.getArticles();
                } else {
                    _this3.$notify.error({
                        title: '错误',
                        message: '文章删除失败'
                    });
                    _this3.getArticles();
                }
            }).catch(function (response) {
                _this3.$notify.error({
                    title: '错误',
                    message: '文章删除失败'
                });
                _this3.getArticles();
            });
        },
        handlePreview: function handlePreview(index, row) {
            window.open("/articles/" + row.id);
        }
    }
});

/***/ }),

/***/ 257:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("section", { staticClass: "main" }, [
    _c(
      "div",
      { staticClass: "crumbs" },
      [
        _c(
          "el-breadcrumb",
          { attrs: { separator: "/" } },
          [
            _c("el-breadcrumb-item", { attrs: { to: { path: "/" } } }, [
              _vm._v("首页")
            ]),
            _vm._v(" "),
            _c("el-breadcrumb-item", [_vm._v("文章管理")]),
            _vm._v(" "),
            _c("el-breadcrumb-item", [_vm._v("文章列表")])
          ],
          1
        )
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loading,
            expression: "loading"
          }
        ]
      },
      [
        _c(
          "div",
          { staticStyle: { float: "right", "margin-bottom": "2rem" } },
          [
            _c(
              "router-link",
              { attrs: { to: "/articles/create" } },
              [
                _c("el-button", { attrs: { type: "primary", icon: "plus" } }, [
                  _vm._v("添加文章")
                ])
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "el-table",
          { staticStyle: { width: "100%" }, attrs: { data: _vm.tableData } },
          [
            _c("el-table-column", {
              attrs: { type: "expand" },
              scopedSlots: _vm._u([
                {
                  key: "default",
                  fn: function(props) {
                    return [
                      _c(
                        "el-form",
                        {
                          staticClass: "demo-table-expand",
                          attrs: { "label-position": "left", inline: "" }
                        },
                        [
                          _c("el-form-item", { attrs: { label: "分类ID" } }, [
                            _c("span", [_vm._v(_vm._s(props.row.category_id))])
                          ]),
                          _vm._v(" "),
                          _c("el-form-item", { attrs: { label: "文章ID" } }, [
                            _c("span", [_vm._v(_vm._s(props.row.id))])
                          ]),
                          _vm._v(" "),
                          _c("el-form-item", { attrs: { label: "点击量" } }, [
                            _c("span", [_vm._v(_vm._s(props.row.page_views))])
                          ]),
                          _vm._v(" "),
                          _c(
                            "el-form-item",
                            { attrs: { label: "标签" } },
                            _vm._l(props.row.tags, function(item) {
                              return _c(
                                "el-tag",
                                { key: item.id, attrs: { type: "primary" } },
                                [
                                  _vm._v(
                                    _vm._s(item.name) +
                                      "\n                            "
                                  )
                                ]
                              )
                            })
                          ),
                          _vm._v(" "),
                          _c("el-form-item", { attrs: { label: "是否推荐" } }, [
                            _c("span", [
                              _vm._v(
                                _vm._s(props.row.recommend === 2 ? "是" : "否")
                              )
                            ])
                          ]),
                          _vm._v(" "),
                          _c("el-form-item", { attrs: { label: "发布状态" } }, [
                            _c("span", [
                              _vm._v(
                                _vm._s(
                                  props.row.publish_status === 2
                                    ? "已发布"
                                    : "草稿"
                                )
                              )
                            ])
                          ]),
                          _vm._v(" "),
                          _c("el-form-item", { attrs: { label: "创建时间" } }, [
                            _c("span", [_vm._v(_vm._s(props.row.created_at))])
                          ]),
                          _vm._v(" "),
                          _c("el-form-item", { attrs: { label: "描述" } }, [
                            _c("span", [_vm._v(_vm._s(props.row.summary))])
                          ])
                        ],
                        1
                      )
                    ]
                  }
                }
              ])
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { label: "文章 ID", width: "150", prop: "id" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: {
                label: "分类",
                width: "180",
                prop: "article_category.name"
              }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { label: "标题", width: "150", prop: "title" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { label: "更新时间", width: "180", prop: "updated_at" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { label: "发布时间", width: "180", prop: "published_at" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { width: "250", label: "操作" },
              scopedSlots: _vm._u([
                {
                  key: "default",
                  fn: function(scope) {
                    return [
                      _c(
                        "el-button",
                        {
                          attrs: { size: "small" },
                          on: {
                            click: function($event) {
                              _vm.handleEdit(scope.$index, scope.row)
                            }
                          }
                        },
                        [_vm._v("编辑\n                    ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-button",
                        {
                          attrs: { size: "small", type: "danger" },
                          on: {
                            click: function($event) {
                              _vm.handleDelete(scope.$index, scope.row)
                            }
                          }
                        },
                        [_vm._v("删除\n                    ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-button",
                        {
                          attrs: { size: "small" },
                          on: {
                            click: function($event) {
                              _vm.handlePreview(scope.$index, scope.row)
                            }
                          }
                        },
                        [_vm._v("预览\n                    ")]
                      )
                    ]
                  }
                }
              ])
            })
          ],
          1
        ),
        _vm._v(" "),
        _c("el-pagination", {
          attrs: {
            layout: "prev, pager, next",
            "page-size": _vm.page.pageSize,
            total: _vm.page.total
          },
          on: { "current-change": _vm.currentChange }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-loader/node_modules/vue-hot-reload-api")      .rerender("data-v-2a1c6ab6", module.exports)
  }
}

/***/ }),

/***/ 76:
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ })

});