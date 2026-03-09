(() => {
	"use strict";
	var r,
		o = {
			149() {
				const r = window.wp.blocks,
					o = window.wp.i18n,
					e = window.wp.blockEditor,
					t = window.ReactJSXRuntime,
					s = JSON.parse('{"UU":"create-block/products-carousel"}');
				(0, r.registerBlockType)(s.UU, {
					edit: function () {
						return (0, t.jsx)("p", {
							...(0, e.useBlockProps)(),
							children: (0, o.__)(
								"Products Carousel – hello from the editor!",
								"products-carousel",
							),
						});
					},
					save: function () {
						return (0, t.jsx)("p", {
							...e.useBlockProps.save(),
							children: "Products Carousel – hello from the saved content!",
						});
					},
				});
			},
		},
		e = {};
	function t(r) {
		var s = e[r];
		if (void 0 !== s) return s.exports;
		var n = (e[r] = { exports: {} });
		return o[r](n, n.exports, t), n.exports;
	}
	(t.m = o),
		(r = []),
		(t.O = (o, e, s, n) => {
			if (!e) {
				var c = 1 / 0;
				for (u = 0; u < r.length; u++) {
					for (var [e, s, n] = r[u], l = !0, i = 0; i < e.length; i++)
						(!1 & n || c >= n) && Object.keys(t.O).every((r) => t.O[r](e[i]))
							? e.splice(i--, 1)
							: ((l = !1), n < c && (c = n));
					if (l) {
						r.splice(u--, 1);
						var a = s();
						void 0 !== a && (o = a);
					}
				}
				return o;
			}
			n = n || 0;
			for (var u = r.length; u > 0 && r[u - 1][2] > n; u--) r[u] = r[u - 1];
			r[u] = [e, s, n];
		}),
		(t.o = (r, o) => Object.prototype.hasOwnProperty.call(r, o)),
		(() => {
			var r = { 871: 0, 511: 0 };
			t.O.j = (o) => 0 === r[o];
			var o = (o, e) => {
					var s,
						n,
						[c, l, i] = e,
						a = 0;
					if (c.some((o) => 0 !== r[o])) {
						for (s in l) t.o(l, s) && (t.m[s] = l[s]);
						if (i) var u = i(t);
					}
					for (o && o(e); a < c.length; a++)
						(n = c[a]), t.o(r, n) && r[n] && r[n][0](), (r[n] = 0);
					return t.O(u);
				},
				e = (globalThis.webpackChunkproducts_carousel =
					globalThis.webpackChunkproducts_carousel || []);
			e.forEach(o.bind(null, 0)), (e.push = o.bind(null, e.push.bind(e)));
		})();
	var s = t.O(void 0, [511], () => t(149));
	s = t.O(s);
})();
