!(function (t, e) {
    "object" == typeof exports && "undefined" != typeof module
        ? (module.exports = e())
        : "function" == typeof define && define.amd
        ? define(e)
        : (t.SignaturePad = e());
})(this, function () {
    "use strict";
    var t = (function () {
            function t(t, e, o) {
                (this.x = t), (this.y = e), (this.time = o || Date.now());
            }
            return (
                (t.prototype.distanceTo = function (t) {
                    return Math.sqrt(
                        Math.pow(this.x - t.x, 2) + Math.pow(this.y - t.y, 2)
                    );
                }),
                (t.prototype.equals = function (t) {
                    return (
                        this.x === t.x && this.y === t.y && this.time === t.time
                    );
                }),
                (t.prototype.velocityFrom = function (t) {
                    return this.time !== t.time
                        ? this.distanceTo(t) / (this.time - t.time)
                        : 0;
                }),
                t
            );
        })(),
        e = (function () {
            function e(t, e, o, n, i, s) {
                (this.startPoint = t),
                    (this.control2 = e),
                    (this.control1 = o),
                    (this.endPoint = n),
                    (this.startWidth = i),
                    (this.endWidth = s);
            }
            return (
                (e.fromPoints = function (t, o) {
                    var n = this.calculateControlPoints(t[0], t[1], t[2]).c2,
                        i = this.calculateControlPoints(t[1], t[2], t[3]).c1;
                    return new e(t[1], n, i, t[2], o.start, o.end);
                }),
                (e.calculateControlPoints = function (e, o, n) {
                    var i = e.x - o.x,
                        s = e.y - o.y,
                        r = o.x - n.x,
                        h = o.y - n.y,
                        a = (e.x + o.x) / 2,
                        c = (e.y + o.y) / 2,
                        u = (o.x + n.x) / 2,
                        d = (o.y + n.y) / 2,
                        l = Math.sqrt(i * i + s * s),
                        v = Math.sqrt(r * r + h * h),
                        p = v / (l + v),
                        f = u + (a - u) * p,
                        _ = d + (c - d) * p,
                        m = o.x - f,
                        y = o.y - _;
                    return { c1: new t(a + m, c + y), c2: new t(u + m, d + y) };
                }),
                (e.prototype.length = function () {
                    for (var t, e, o = 0, n = 0; n <= 10; n += 1) {
                        var i = n / 10,
                            s = this.point(
                                i,
                                this.startPoint.x,
                                this.control1.x,
                                this.control2.x,
                                this.endPoint.x
                            ),
                            r = this.point(
                                i,
                                this.startPoint.y,
                                this.control1.y,
                                this.control2.y,
                                this.endPoint.y
                            );
                        if (n > 0) {
                            var h = s - t,
                                a = r - e;
                            o += Math.sqrt(h * h + a * a);
                        }
                        (t = s), (e = r);
                    }
                    return o;
                }),
                (e.prototype.point = function (t, e, o, n, i) {
                    return (
                        e * (1 - t) * (1 - t) * (1 - t) +
                        3 * o * (1 - t) * (1 - t) * t +
                        3 * n * (1 - t) * t * t +
                        i * t * t * t
                    );
                }),
                e
            );
        })();
    return (function () {
        function o(t, e) {
            void 0 === e && (e = {});
            var n = this;
            (this.canvas = t),
                (this.options = e),
                (this._handleMouseDown = function (t) {
                    1 === t.which &&
                        ((n._mouseButtonDown = !0), n._strokeBegin(t));
                }),
                (this._handleMouseMove = function (t) {
                    n._mouseButtonDown && n._strokeMoveUpdate(t);
                }),
                (this._handleMouseUp = function (t) {
                    1 === t.which &&
                        n._mouseButtonDown &&
                        ((n._mouseButtonDown = !1), n._strokeEnd(t));
                }),
                (this._handleTouchStart = function (t) {
                    if ((t.preventDefault(), 1 === t.targetTouches.length)) {
                        var e = t.changedTouches[0];
                        n._strokeBegin(e);
                    }
                }),
                (this._handleTouchMove = function (t) {
                    t.preventDefault();
                    var e = t.targetTouches[0];
                    n._strokeMoveUpdate(e);
                }),
                (this._handleTouchEnd = function (t) {
                    if (t.target === n.canvas) {
                        t.preventDefault();
                        var e = t.changedTouches[0];
                        n._strokeEnd(e);
                    }
                }),
                (this.velocityFilterWeight = e.velocityFilterWeight || 0.7),
                (this.minWidth = e.minWidth || 0.5),
                (this.maxWidth = e.maxWidth || 2.5),
                (this.throttle = "throttle" in e ? e.throttle : 16),
                (this.minDistance = "minDistance" in e ? e.minDistance : 5),
                this.throttle
                    ? (this._strokeMoveUpdate = (function (t, e) {
                          void 0 === e && (e = 250);
                          var o,
                              n,
                              i,
                              s = 0,
                              r = null,
                              h = function () {
                                  (s = Date.now()),
                                      (r = null),
                                      (o = t.apply(n, i)),
                                      r || ((n = null), (i = []));
                              };
                          return function () {
                              for (var a = [], c = 0; c < arguments.length; c++)
                                  a[c] = arguments[c];
                              var u = Date.now(),
                                  d = e - (u - s);
                              return (
                                  (n = this),
                                  (i = a),
                                  d <= 0 || d > e
                                      ? (r && (clearTimeout(r), (r = null)),
                                        (s = u),
                                        (o = t.apply(n, i)),
                                        r || ((n = null), (i = [])))
                                      : r || (r = window.setTimeout(h, d)),
                                  o
                              );
                          };
                      })(o.prototype._strokeUpdate, this.throttle))
                    : (this._strokeMoveUpdate = o.prototype._strokeUpdate),
                (this.dotSize =
                    e.dotSize ||
                    function () {
                        return (this.minWidth + this.maxWidth) / 2;
                    }),
                (this.penColor = e.penColor || "black"),
                (this.backgroundColor = e.backgroundColor || "rgba(0,0,0,0)"),
                (this.onBegin = e.onBegin),
                (this.onEnd = e.onEnd),
                (this._ctx = t.getContext("2d")),
                this.clear(),
                this.on();
        }
        return (
            (o.prototype.clear = function () {
                var t = this._ctx,
                    e = this.canvas;
                (t.fillStyle = this.backgroundColor),
                    t.clearRect(0, 0, e.width, e.height),
                    t.fillRect(0, 0, e.width, e.height),
                    (this._data = []),
                    this._reset(),
                    (this._isEmpty = !0);
            }),
            (o.prototype.fromDataURL = function (t, e, o) {
                var n = this;
                void 0 === e && (e = {});
                var i = new Image(),
                    s = e.ratio || window.devicePixelRatio || 1,
                    r = e.width || this.canvas.width / s,
                    h = e.height || this.canvas.height / s;
                this._reset(),
                    (i.onload = function () {
                        n._ctx.drawImage(i, 0, 0, r, h), o && o();
                    }),
                    (i.onerror = function (t) {
                        o && o(t);
                    }),
                    (i.src = t),
                    (this._isEmpty = !1);
            }),
            (o.prototype.toDataURL = function (t, e) {
                switch ((void 0 === t && (t = "image/png"), t)) {
                    case "image/svg+xml":
                        return this._toSVG();
                    default:
                        return this.canvas.toDataURL(t, e);
                }
            }),
            (o.prototype.on = function () {
                (this.canvas.style.touchAction = "none"),
                    (this.canvas.style.msTouchAction = "none"),
                    window.PointerEvent
                        ? this._handlePointerEvents()
                        : (this._handleMouseEvents(),
                          "ontouchstart" in window &&
                              this._handleTouchEvents());
            }),
            (o.prototype.off = function () {
                (this.canvas.style.touchAction = "auto"),
                    (this.canvas.style.msTouchAction = "auto"),
                    this.canvas.removeEventListener(
                        "pointerdown",
                        this._handleMouseDown
                    ),
                    this.canvas.removeEventListener(
                        "pointermove",
                        this._handleMouseMove
                    ),
                    document.removeEventListener(
                        "pointerup",
                        this._handleMouseUp
                    ),
                    this.canvas.removeEventListener(
                        "mousedown",
                        this._handleMouseDown
                    ),
                    this.canvas.removeEventListener(
                        "mousemove",
                        this._handleMouseMove
                    ),
                    document.removeEventListener(
                        "mouseup",
                        this._handleMouseUp
                    ),
                    this.canvas.removeEventListener(
                        "touchstart",
                        this._handleTouchStart
                    ),
                    this.canvas.removeEventListener(
                        "touchmove",
                        this._handleTouchMove
                    ),
                    this.canvas.removeEventListener(
                        "touchend",
                        this._handleTouchEnd
                    );
            }),
            (o.prototype.isEmpty = function () {
                return this._isEmpty;
            }),
            (o.prototype.fromData = function (t) {
                var e = this;
                this.clear(),
                    this._fromData(
                        t,
                        function (t) {
                            var o = t.color,
                                n = t.curve;
                            return e._drawCurve({ color: o, curve: n });
                        },
                        function (t) {
                            var o = t.color,
                                n = t.point;
                            return e._drawDot({ color: o, point: n });
                        }
                    ),
                    (this._data = t);
            }),
            (o.prototype.toData = function () {
                return this._data;
            }),
            (o.prototype._strokeBegin = function (t) {
                var e = { color: this.penColor, points: [] };
                this._data.push(e),
                    this._reset(),
                    this._strokeUpdate(t),
                    "function" == typeof this.onBegin && this.onBegin(t);
            }),
            (o.prototype._strokeUpdate = function (t) {
                var e = t.clientX,
                    o = t.clientY,
                    n = this._createPoint(e, o),
                    i = this._data[this._data.length - 1],
                    s = i.points,
                    r = s.length > 0 && s[s.length - 1],
                    h = !!r && n.distanceTo(r) <= this.minDistance,
                    a = i.color;
                if (!r || !r || !h) {
                    var c = this._addPoint(n);
                    r
                        ? c && this._drawCurve({ color: a, curve: c })
                        : this._drawDot({ color: a, point: n }),
                        s.push({ time: n.time, x: n.x, y: n.y });
                }
            }),
            (o.prototype._strokeEnd = function (t) {
                this._strokeUpdate(t),
                    "function" == typeof this.onEnd && this.onEnd(t);
            }),
            (o.prototype._handlePointerEvents = function () {
                (this._mouseButtonDown = !1),
                    this.canvas.addEventListener(
                        "pointerdown",
                        this._handleMouseDown
                    ),
                    this.canvas.addEventListener(
                        "pointermove",
                        this._handleMouseMove
                    ),
                    document.addEventListener("pointerup", this._handleMouseUp);
            }),
            (o.prototype._handleMouseEvents = function () {
                (this._mouseButtonDown = !1),
                    this.canvas.addEventListener(
                        "mousedown",
                        this._handleMouseDown
                    ),
                    this.canvas.addEventListener(
                        "mousemove",
                        this._handleMouseMove
                    ),
                    document.addEventListener("mouseup", this._handleMouseUp);
            }),
            (o.prototype._handleTouchEvents = function () {
                this.canvas.addEventListener(
                    "touchstart",
                    this._handleTouchStart
                ),
                    this.canvas.addEventListener(
                        "touchmove",
                        this._handleTouchMove
                    ),
                    this.canvas.addEventListener(
                        "touchend",
                        this._handleTouchEnd
                    );
            }),
            (o.prototype._reset = function () {
                (this._lastPoints = []),
                    (this._lastVelocity = 0),
                    (this._lastWidth = (this.minWidth + this.maxWidth) / 2),
                    (this._ctx.fillStyle = this.penColor);
            }),
            (o.prototype._createPoint = function (e, o) {
                var n = this.canvas.getBoundingClientRect();
                return new t(e - n.left, o - n.top, new Date().getTime());
            }),
            (o.prototype._addPoint = function (t) {
                var o = this._lastPoints;
                if ((o.push(t), o.length > 2)) {
                    3 === o.length && o.unshift(o[0]);
                    var n = this._calculateCurveWidths(o[1], o[2]),
                        i = e.fromPoints(o, n);
                    return o.shift(), i;
                }
                return null;
            }),
            (o.prototype._calculateCurveWidths = function (t, e) {
                var o =
                        this.velocityFilterWeight * e.velocityFrom(t) +
                        (1 - this.velocityFilterWeight) * this._lastVelocity,
                    n = this._strokeWidth(o),
                    i = { end: n, start: this._lastWidth };
                return (this._lastVelocity = o), (this._lastWidth = n), i;
            }),
            (o.prototype._strokeWidth = function (t) {
                return Math.max(this.maxWidth / (t + 1), this.minWidth);
            }),
            (o.prototype._drawCurveSegment = function (t, e, o) {
                var n = this._ctx;
                n.moveTo(t, e),
                    n.arc(t, e, o, 0, 2 * Math.PI, !1),
                    (this._isEmpty = !1);
            }),
            (o.prototype._drawCurve = function (t) {
                var e = t.color,
                    o = t.curve,
                    n = this._ctx,
                    i = o.endWidth - o.startWidth,
                    s = 2 * Math.floor(o.length());
                n.beginPath(), (n.fillStyle = e);
                for (var r = 0; r < s; r += 1) {
                    var h = r / s,
                        a = h * h,
                        c = a * h,
                        u = 1 - h,
                        d = u * u,
                        l = d * u,
                        v = l * o.startPoint.x;
                    (v += 3 * d * h * o.control1.x),
                        (v += 3 * u * a * o.control2.x),
                        (v += c * o.endPoint.x);
                    var p = l * o.startPoint.y;
                    (p += 3 * d * h * o.control1.y),
                        (p += 3 * u * a * o.control2.y),
                        (p += c * o.endPoint.y);
                    var f = o.startWidth + c * i;
                    this._drawCurveSegment(v, p, f);
                }
                n.closePath(), n.fill();
            }),
            (o.prototype._drawDot = function (t) {
                var e = t.color,
                    o = t.point,
                    n = this._ctx,
                    i =
                        "function" == typeof this.dotSize
                            ? this.dotSize()
                            : this.dotSize;
                n.beginPath(),
                    this._drawCurveSegment(o.x, o.y, i),
                    n.closePath(),
                    (n.fillStyle = e),
                    n.fill();
            }),
            (o.prototype._fromData = function (e, o, n) {
                for (var i = 0, s = e; i < s.length; i++) {
                    var r = s[i],
                        h = r.color,
                        a = r.points;
                    if (a.length > 1)
                        for (var c = 0; c < a.length; c += 1) {
                            var u = a[c],
                                d = new t(u.x, u.y, u.time);
                            (this.penColor = h), 0 === c && this._reset();
                            var l = this._addPoint(d);
                            l && o({ color: h, curve: l });
                        }
                    else this._reset(), n({ color: h, point: a[0] });
                }
            }),
            (o.prototype._toSVG = function () {
                var t = this,
                    e = this._data,
                    o = Math.max(window.devicePixelRatio || 1, 1),
                    n = this.canvas.width / o,
                    i = this.canvas.height / o,
                    s = document.createElementNS(
                        "http://www.w3.org/2000/svg",
                        "svg"
                    );
                s.setAttribute("width", this.canvas.width.toString()),
                    s.setAttribute("height", this.canvas.height.toString()),
                    this._fromData(
                        e,
                        function (t) {
                            var e = t.color,
                                o = t.curve,
                                n = document.createElement("path");
                            if (
                                !(
                                    isNaN(o.control1.x) ||
                                    isNaN(o.control1.y) ||
                                    isNaN(o.control2.x) ||
                                    isNaN(o.control2.y)
                                )
                            ) {
                                var i =
                                    "M " +
                                    o.startPoint.x.toFixed(3) +
                                    "," +
                                    o.startPoint.y.toFixed(3) +
                                    " C " +
                                    o.control1.x.toFixed(3) +
                                    "," +
                                    o.control1.y.toFixed(3) +
                                    " " +
                                    o.control2.x.toFixed(3) +
                                    "," +
                                    o.control2.y.toFixed(3) +
                                    " " +
                                    o.endPoint.x.toFixed(3) +
                                    "," +
                                    o.endPoint.y.toFixed(3);
                                n.setAttribute("d", i),
                                    n.setAttribute(
                                        "stroke-width",
                                        (2.25 * o.endWidth).toFixed(3)
                                    ),
                                    n.setAttribute("stroke", e),
                                    n.setAttribute("fill", "none"),
                                    n.setAttribute("stroke-linecap", "round"),
                                    s.appendChild(n);
                            }
                        },
                        function (e) {
                            var o = e.color,
                                n = e.point,
                                i = document.createElement("circle"),
                                r =
                                    "function" == typeof t.dotSize
                                        ? t.dotSize()
                                        : t.dotSize;
                            i.setAttribute("r", r.toString()),
                                i.setAttribute("cx", n.x.toString()),
                                i.setAttribute("cy", n.y.toString()),
                                i.setAttribute("fill", o),
                                s.appendChild(i);
                        }
                    );
                var r =
                        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 ' +
                        n +
                        " " +
                        i +
                        '" width="' +
                        n +
                        '" height="' +
                        i +
                        '">',
                    h = s.innerHTML;
                if (void 0 === h) {
                    var a = document.createElement("dummy"),
                        c = s.childNodes;
                    a.innerHTML = "";
                    for (var u = 0; u < c.length; u += 1)
                        a.appendChild(c[u].cloneNode(!0));
                    h = a.innerHTML;
                }
                return "data:image/svg+xml;base64," + btoa(r + h + "</svg>");
            }),
            o
        );
    })();
});
