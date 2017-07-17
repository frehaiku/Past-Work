/**
 * Created by frehaiku on 2017/6/1.
 */
let key
function isArray(arr) {
  return Array.isArray(arr) || arr instanceof Array
}

function isObject(obj) {
  return ({}).toString.call(obj) === '[object Object]'
}
let _extends = function (target, sources, deep) {
  for (key in sources)
    if (deep && isObject(sources[key]) || isArray(sources[key])) {
      if (isObject(sources[key]) && !isObject(target[key]))
        target[key] = {}
      if (isArray(sources[key]) && !isArray(target[key]))
        target[key] = []
      _extends(target[key], sources[key], deep)
    } else if (sources[key] != null)
      target[key] = sources[key]
}
// 第一个参数为boolean表示是否深复制
// 没有时，默认为浅复制
// 深复制：(true, target, sources1, sources2, ...)
// 浅复制：(target, sources1, sources2, ...)
export const extend = function (target) {
  let deep, args = Array.from(arguments).slice(1)

  if (typeof target == 'boolean') {
    deep = target
    target = args.shift()
  }
  args.forEach(ele => _extends(target, ele, deep))
  return target
}