import { Controller } from '@hotwired/stimulus';

const MARKER_SIZE = 40;
const MARKER_SHADOW_PADDING = 8;
const MARKER_CANVAS_SIZE = MARKER_SIZE + MARKER_SHADOW_PADDING * 2;
const MARKER_BACKGROUND = '#216B4C';
const MARKER_ICON_STROKE = '#216B4C';

export default class extends Controller {
    static targets = ['map', 'fallback'];
    static values = {
        apiKey: String,
        lat: Number,
        lng: Number,
        addressIcon: String,
    };

    connect()
    {
        if (!this.apiKeyValue || this.apiKeyValue.trim() === '') {
            return;
        }
        this.loadGoogleMapsScript()
            .then(() => this.renderMap())
            .catch(() => {
                // Google Maps failed to load (e.g. offline/unreachable) — fallbackTarget stays visible.
            });
    }

    loadGoogleMapsScript()
    {
        if (window.google?.maps) {
            return Promise.resolve();
        }

        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${encodeURIComponent(this.apiKeyValue)}`;
            script.async = true;
            script.onload = () => resolve();
            script.onerror = () => reject(new Error('Failed to load the Google Maps JavaScript API'));
            document.head.appendChild(script);
        });
    }

    async renderMap()
    {
        const position = { lat: this.latValue, lng: this.lngValue };

        const map = new google.maps.Map(this.mapTarget, {
            center: position,
            zoom: 16,
            mapTypeControl: false,
            streetViewControl: false,
        });

        new google.maps.Marker({
            position,
            map,
            icon: {
                url: await this.buildMarkerIconUrl(),
                scaledSize: new google.maps.Size(MARKER_CANVAS_SIZE, MARKER_CANVAS_SIZE),
                anchor: new google.maps.Point(MARKER_CANVAS_SIZE / 2, MARKER_CANVAS_SIZE / 2),
            },
        });

        this.mapTarget.hidden = false;
        this.fallbackTarget.hidden = true;
    }

    async buildMarkerIconUrl()
    {
        const response = await fetch(this.addressIconValue);
        const svgText = await response.text();
        const iconMarkup = svgText
            .replace(/<\?xml[^>]*\?>/, '')
            .replace(/<svg[^>]*>/, '')
            .replace(/<\/svg>/, '')
            .replaceAll(`stroke="${MARKER_ICON_STROKE}"`, 'stroke="#FFFFFF"');

        const center = MARKER_CANVAS_SIZE / 2;
        const iconOffset = (MARKER_CANVAS_SIZE - 20) / 2;
        const svg = `<svg width="${MARKER_CANVAS_SIZE}" height="${MARKER_CANVAS_SIZE}" viewBox="0 0 ${MARKER_CANVAS_SIZE} ${MARKER_CANVAS_SIZE}" xmlns="http://www.w3.org/2000/svg">`
            + '<defs><filter id="marker-shadow" x="-50%" y="-50%" width="200%" height="200%">'
            + '<feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#000000" flood-opacity="0.3"/>'
            + '</filter></defs>'
            + `<circle cx="${center}" cy="${center}" r="${MARKER_SIZE / 2}" fill="${MARKER_BACKGROUND}" filter="url(#marker-shadow)"/>`
            + `<g fill="none" transform="translate(${iconOffset}, ${iconOffset})">${iconMarkup}</g>`
            + '</svg>';

        return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`;
    }
}
