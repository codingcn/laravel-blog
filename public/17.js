webpackJsonp([17],{

/***/ 214:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(450)
}
var normalizeComponent = __webpack_require__(76)
/* script */
var __vue_script__ = __webpack_require__(452)
/* template */
var __vue_template__ = __webpack_require__(453)
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
Component.options.__file = "resources\\assets\\admin\\js\\components\\page\\Links.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-loader/node_modules/vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2ea715e0", Component.options)
  } else {
    hotAPI.reload("data-v-2ea715e0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 216:
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

var listToStyles = __webpack_require__(217)

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

/***/ 217:
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

/***/ 450:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(451);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(216)("38551f18", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/_css-loader@0.28.9@css-loader/index.js!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-2ea715e0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/selector.js?type=styles&index=0!./Links.vue", function() {
     var newContent = require("!!../../../../../../node_modules/_css-loader@0.28.9@css-loader/index.js!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-2ea715e0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/_vue-loader@13.7.1@vue-loader/lib/selector.js?type=styles&index=0!./Links.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 451:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(98)(false);
// imports


// module
exports.push([module.i, "\n.demo-table-expand {\n    font-size: 0;\n}\n.demo-table-expand label {\n    width: 90px;\n    color: #99a9bf;\n}\n.demo-table-expand .el-form-item {\n    margin-right: 0;\n    margin-bottom: 0;\n    width: 50%;\n}\n", ""]);

// exports


/***/ }),

/***/ 452:
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
    beforeMount: function beforeMount() {
        this.getLinks();
    },
    data: function data() {
        return {
            loading: false,
            tableData: [],
            page: {},
            dialogEditFormVisible: false,
            dialogCreateFormVisible: false,
            editForm: {
                id: 0,
                name: '',
                uri: '',
                description: '',
                serial_number: 0
            },
            createForm: {
                name: '',
                uri: '',
                description: '',
                serial_number: 0
            },
            formLabelWidth: '120px'
        };
    },

    methods: {
        getLinks: function getLinks() {
            var _this = this;

            this.loading = true;
            this.$axios({
                url: this.$difines.root_url + '/api/admin/links',
                method: 'get'
            }).then(function (response) {
                _this.tableData = response.data.data.data;
                _this.page.pageSize = response.data.data.per_page;
                _this.page.total = response.data.data.total;
                _this.loading = false;
            }).catch(function (response) {});
        },
        currentChange: function currentChange(p) {
            var _this2 = this;

            this.loading = true;
            this.$axios({
                url: this.$difines.root_url + '/api/admin/links?page=' + p,
                method: 'get'
            }).then(function (response) {
                _this2.tableData = response.data.data.data;
                _this2.page.pageSize = response.data.data.per_page;
                _this2.page.total = response.data.data.total;
                _this2.loading = false;
            }).catch(function (response) {});
        },
        updateLink: function updateLink() {
            var _this3 = this;

            this.$axios({
                url: this.$difines.root_url + '/api/admin/links/' + this.editForm.id,
                method: 'PUT',
                data: {
                    name: this.editForm.name,
                    uri: this.editForm.uri,
                    description: this.editForm.description,
                    serial_number: this.editForm.serial_number
                }
            }).then(function (response) {
                if (response.data.err_no !== 0) {
                    _this3.$notify.error({
                        title: '错误',
                        message: '友链修改失败'
                    });
                } else {
                    _this3.$notify.success({
                        title: '成功',
                        message: '友链修改成功'
                    });
                }
            }).catch(function (response) {});
        },
        storeLink: function storeLink() {
            var _this4 = this;

            this.$axios({
                url: this.$difines.root_url + '/api/admin/links',
                method: 'POST',
                data: {
                    name: this.createForm.name,
                    uri: this.createForm.uri,
                    description: this.createForm.description,
                    serial_number: this.createForm.serial_number
                }
            }).then(function (response) {
                if (response.data.err_no !== 0) {
                    _this4.$notify.error({
                        title: '错误',
                        message: '友链添加失败'
                    });
                    _this4.getLinks();
                } else {
                    _this4.$notify.success({
                        title: '成功',
                        message: '友链添加成功'
                    });
                    _this4.getLinks();
                }
            }).catch(function (response) {});
        },
        handleEdit: function handleEdit(index, row) {
            this.editForm = row;
        },
        handleDelete: function handleDelete(index, row) {
            var _this5 = this;

            this.$axios({
                url: this.$difines.root_url + '/api/admin/links/' + row.id,
                method: 'DELETE'
            }).then(function (response) {
                if (response.data.err_no !== 0) {
                    _this5.$notify.error({
                        title: '错误',
                        message: '删除失败'
                    });
                    _this5.getLinks();
                } else {
                    _this5.$notify.success({
                        title: '成功',
                        message: '删除成功'
                    });
                    _this5.getLinks();
                }
            }).catch(function (response) {});
        }
    }
});

/***/ }),

/***/ 453:
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
            _c("el-breadcrumb-item", [_vm._v("友链管理")]),
            _vm._v(" "),
            _c("el-breadcrumb-item", [_vm._v("友链列表")])
          ],
          1
        )
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      [
        _c(
          "div",
          { staticStyle: { float: "right", "margin-bottom": "2rem" } },
          [
            _c(
              "el-button",
              {
                attrs: { type: "primary", icon: "plus" },
                on: {
                  click: function($event) {
                    _vm.dialogCreateFormVisible = true
                  }
                }
              },
              [_vm._v("添加友链")]
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "el-table",
          {
            directives: [
              {
                name: "loading",
                rawName: "v-loading",
                value: _vm.loading,
                expression: "loading"
              }
            ],
            staticStyle: { width: "100%" },
            attrs: { data: _vm.tableData }
          },
          [
            _c("el-table-column", { attrs: { width: "60" } }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { prop: "id", label: "ID", width: "60" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { prop: "name", label: "站点名", width: "100" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { prop: "uri", label: "站点链接", width: "180" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { prop: "description", label: "站点描述", width: "180" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { prop: "serial_number", label: "排序", width: "60" }
            }),
            _vm._v(" "),
            _c("el-table-column", {
              attrs: { prop: "updated_at", label: "更新时间", width: "200" }
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
                              _vm.dialogEditFormVisible = true
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                        编 辑\n                    "
                          )
                        ]
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
                        [_vm._v("删 除\n                    ")]
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
        }),
        _vm._v(" "),
        _c(
          "el-dialog",
          {
            attrs: { title: "编辑友链", visible: _vm.dialogEditFormVisible },
            on: {
              "update:visible": function($event) {
                _vm.dialogEditFormVisible = $event
              }
            }
          },
          [
            _c(
              "el-form",
              { attrs: { model: _vm.editForm } },
              [
                _c(
                  "el-form-item",
                  {
                    attrs: {
                      label: "站点名称",
                      "label-width": _vm.formLabelWidth
                    }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.editForm.name,
                        callback: function($$v) {
                          _vm.$set(_vm.editForm, "name", $$v)
                        },
                        expression: "editForm.name"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  {
                    attrs: {
                      label: "站点链接",
                      "label-width": _vm.formLabelWidth
                    }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.editForm.uri,
                        callback: function($$v) {
                          _vm.$set(_vm.editForm, "uri", $$v)
                        },
                        expression: "editForm.uri"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  {
                    attrs: {
                      label: "站点描述",
                      "label-width": _vm.formLabelWidth
                    }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.editForm.description,
                        callback: function($$v) {
                          _vm.$set(_vm.editForm, "description", $$v)
                        },
                        expression: "editForm.description"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  {
                    attrs: { label: "排序", "label-width": _vm.formLabelWidth }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.editForm.serial_number,
                        callback: function($$v) {
                          _vm.$set(_vm.editForm, "serial_number", $$v)
                        },
                        expression: "editForm.serial_number"
                      }
                    })
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
                staticClass: "dialog-footer",
                attrs: { slot: "footer" },
                slot: "footer"
              },
              [
                _c(
                  "el-button",
                  {
                    on: {
                      click: function($event) {
                        _vm.dialogEditFormVisible = false
                      }
                    }
                  },
                  [_vm._v("取 消")]
                ),
                _vm._v(" "),
                _c(
                  "el-button",
                  {
                    attrs: { type: "primary" },
                    on: {
                      click: function($event) {
                        _vm.updateLink()
                        _vm.dialogEditFormVisible = false
                      }
                    }
                  },
                  [_vm._v("确 定")]
                )
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "el-dialog",
          {
            attrs: { title: "编辑友链", visible: _vm.dialogCreateFormVisible },
            on: {
              "update:visible": function($event) {
                _vm.dialogCreateFormVisible = $event
              }
            }
          },
          [
            _c(
              "el-form",
              { attrs: { model: _vm.createForm } },
              [
                _c(
                  "el-form-item",
                  {
                    attrs: {
                      label: "站点名称",
                      "label-width": _vm.formLabelWidth
                    }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.createForm.name,
                        callback: function($$v) {
                          _vm.$set(_vm.createForm, "name", $$v)
                        },
                        expression: "createForm.name"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  {
                    attrs: {
                      label: "站点链接",
                      "label-width": _vm.formLabelWidth
                    }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.createForm.uri,
                        callback: function($$v) {
                          _vm.$set(_vm.createForm, "uri", $$v)
                        },
                        expression: "createForm.uri"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  {
                    attrs: {
                      label: "站点描述",
                      "label-width": _vm.formLabelWidth
                    }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.createForm.description,
                        callback: function($$v) {
                          _vm.$set(_vm.createForm, "description", $$v)
                        },
                        expression: "createForm.description"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  {
                    attrs: { label: "排序", "label-width": _vm.formLabelWidth }
                  },
                  [
                    _c("el-input", {
                      attrs: { "auto-complete": "off" },
                      model: {
                        value: _vm.createForm.serial_number,
                        callback: function($$v) {
                          _vm.$set(_vm.createForm, "serial_number", $$v)
                        },
                        expression: "createForm.serial_number"
                      }
                    })
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
                staticClass: "dialog-footer",
                attrs: { slot: "footer" },
                slot: "footer"
              },
              [
                _c(
                  "el-button",
                  {
                    on: {
                      click: function($event) {
                        _vm.dialogCreateFormVisible = false
                      }
                    }
                  },
                  [_vm._v("取 消")]
                ),
                _vm._v(" "),
                _c(
                  "el-button",
                  {
                    attrs: { type: "primary" },
                    on: {
                      click: function($event) {
                        _vm.storeLink()
                        _vm.dialogCreateFormVisible = false
                      }
                    }
                  },
                  [_vm._v("确 定")]
                )
              ],
              1
            )
          ],
          1
        )
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
    require("vue-loader/node_modules/vue-hot-reload-api")      .rerender("data-v-2ea715e0", module.exports)
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