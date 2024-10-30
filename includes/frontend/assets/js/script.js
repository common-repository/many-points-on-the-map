(function () {

	function isJSON(str) {
		try {
			JSON.parse(str);
		} catch (e) {
			return false;
		}
		return true;
	}

	window.mxmpotm_map_generator = window.mxmpotm_map_generator || {

		container: 'mxmpotm_map',
		filter_container: 'mx-map-select',
		map_data: {},

		init_filter: function (map, container) {

			const _this = this;

			container.addEventListener('change', function (e) {

				const coordinates = this.value.split(',');

				let lat = Number(_this.map_data.latitude_map_center);
				let lng = Number(_this.map_data.longitude_map_center);
				let zoom = parseInt(_this.map_data.zoom_map_center)

				if (coordinates[0] !== '') {

					lat = coordinates[0];
					lng = coordinates[1];
					zoom = parseInt(_this.map_data.zoom_to_point)

				}

				var panPoint = new google.maps.LatLng(Number(lat), Number(lng));
				map.zoom = zoom;
				map.panTo(panPoint);
			});

		},

		setMarker: function (marker, defaultMarker) {
			if (marker === '0') {
				return defaultMarker.element
			} else {
				const content = document.createElement("div");
				content.innerHTML = `
				<img src="${marker}" width="35px" height="35px" />
			`;
				return content;
			}
		},

		init_map: async function (container) {

			const _this = this;

			const data = container.getAttribute('data-mx-map');

			const map_id = container.getAttribute('data-map_id');

			if (isJSON(data)) {

				const map_data = JSON.parse(data);

				_this.map_data = map_data;

				const {
					Map,
					InfoWindow
				} = await google.maps.importLibrary("maps");

				const {
					AdvancedMarkerElement,
					PinElement
				} = await google.maps.importLibrary("marker");

				const map = new Map(container, {
					zoom: parseInt(map_data.zoom_map_center),
					center: {
						lat: Number(map_data.latitude_map_center),
						lng: Number(map_data.longitude_map_center)
					},
					mapId: map_id
				});

				let tourStops = []

				map_data.points.forEach(element => {

					let tmp = {
						position: {},
						title: `<div class="mx-toolbar"></div>`,
						pointMarker: '0'
					};

					for (const property in element) {
						if (property === 'point_latitude') {
							tmp.position.lat = Number(element[property])
						}
						if (property === 'point_longitude') {
							tmp.position.lng = Number(element[property])
						}

						tmp.title = `<div class="mx-toolbar">
								
								<h5>${element['point_name']}</h5>

								<div class="mx-desc">${element['point_desc']}</div>

								<div class="mx-address">${element['point_address']}</div>

								<div class="mx-additional">${element['point_additional']}</div>

								<div class="mx-phone">${element['phone']}</div>

								<div class="mx-web_site"><a href="${element['web_site']}" target="_blank">${element['web_site']}</a></div>

								<div class="mx-areas">${element['areas'].join(', ')}</div>
							
							</div>`;

						tmp.pointMarker = element['point_custom_marker'];

					}

					tourStops.push(tmp);

				});

				const infoWindow = new InfoWindow();

				tourStops.forEach(({
					position,
					title,
					pointMarker
				}, i) => {
					const pin = new PinElement();

					const marker = new AdvancedMarkerElement({
						position,
						map,
						title: title,
						content: _this.setMarker(pointMarker, pin)
					});

					marker.addListener("click", ({
						domEvent,
						latLng
					}) => {
						const {
							target
						} = domEvent;
						infoWindow.close();
						infoWindow.setContent(marker.title);
						infoWindow.open(marker.map, marker);
					});
				});

				// filter
				const select = document.getElementById(_this.filter_container);

				if (select !== null) {

					_this.init_filter(map, select);

				}

			}


		},

		prepare_map: function () {

			const container = document.getElementById(this.container);

			if (typeof container !== 'undefined') {

				this.init_map(container);

			}

		},

		init: function () {

			this.prepare_map();

		}

	};

})();


function mx_map_init() {
	mxmpotm_map_generator.init();
}
