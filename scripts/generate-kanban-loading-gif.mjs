/**
 * Flat modern kanban GIF — slate neutrals, primary accent strip, generous radii, solid shapes.
 * Motion unchanged. Run: npm run generate:kanban-gif
 */
import gifenc from 'gifenc';
const { GIFEncoder, quantize, applyPalette } = gifenc;
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const OUT = path.join(__dirname, '..', 'public', 'images', 'kanban-loading.gif');

const W = 300;
const H = 300;
const FRAMES = 56;
const DELAY_MS = 30;

const BG = [248, 250, 252];
const BOARD = [255, 255, 255];
const BOARD_HEADER = [241, 245, 249];
const ACCENT = [99, 102, 241];
const LANE = [248, 250, 252];
const DIVIDER = [226, 232, 240];
const MARKER_RAD = 2;

const COLS = [
    { fill: [99, 102, 241], stripe: [67, 56, 202], top: [199, 210, 254] },
    { fill: [124, 58, 237], stripe: [91, 33, 182], top: [221, 214, 254] },
    { fill: [79, 70, 229], stripe: [55, 48, 163], top: [196, 181, 253] },
];

function setPixel(buf, px, py, r, g, b) {
    if (px < 0 || px >= W || py < 0 || py >= H) return;
    const i = (py * W + px) * 4;
    buf[i] = r;
    buf[i + 1] = g;
    buf[i + 2] = b;
    buf[i + 3] = 255;
}

function fillRoundRect(buf, x, y, rw, rh, rad, r, g, b) {
    const rr = Math.max(0, Math.min(rad, Math.floor(rw / 2), Math.floor(rh / 2)));
    const x0 = Math.max(0, Math.floor(x));
    const y0 = Math.max(0, Math.floor(y));
    const x1 = Math.min(W, Math.ceil(x + rw));
    const y1 = Math.min(H, Math.ceil(y + rh));
    const r2 = rr * rr;

    function inCorner(px, py, cx, cy) {
        const dx = px + 0.5 - cx;
        const dy = py + 0.5 - cy;
        return dx * dx + dy * dy <= r2;
    }

    for (let py = y0; py < y1; py++) {
        for (let px = x0; px < x1; px++) {
            if (px < x || px >= x + rw || py < y || py >= y + rh) continue;
            let ok = true;
            if (px < x + rr && py < y + rr && !inCorner(px, py, x + rr, y + rr)) ok = false;
            else if (px >= x + rw - rr && py < y + rr && !inCorner(px, py, x + rw - rr, y + rr)) ok = false;
            else if (px < x + rr && py >= y + rh - rr && !inCorner(px, py, x + rr, y + rh - rr)) ok = false;
            else if (px >= x + rw - rr && py >= y + rh - rr && !inCorner(px, py, x + rw - rr, y + rh - rr)) ok = false;
            if (ok) setPixel(buf, px, py, r, g, b);
        }
    }
}

function fillRect(buf, x0, y0, x1, y1, r, g, b) {
    x0 = Math.max(0, Math.min(W, Math.floor(x0)));
    x1 = Math.max(0, Math.min(W, Math.ceil(x1)));
    y0 = Math.max(0, Math.min(H, Math.floor(y0)));
    y1 = Math.max(0, Math.min(H, Math.ceil(y1)));
    for (let py = y0; py < y1; py++) {
        for (let px = x0; px < x1; px++) {
            setPixel(buf, px, py, r, g, b);
        }
    }
}

function fillBgFlat(buf) {
    fillRect(buf, 0, 0, W, H, ...BG);
}

function drawCardFlat(buf, x, y, cw, ch, rad, col, shineAmt) {
    const [fr, fg, fb] = col.fill;
    const [sr, sg, sb] = col.stripe;
    const [tr, tg, tb] = col.top;
    const stripeW = 5;
    const topH = 4;
    const x0 = Math.max(0, Math.floor(x));
    const y0 = Math.max(0, Math.floor(y));
    const x1 = Math.min(W, Math.ceil(x + cw));
    const y1 = Math.min(H, Math.ceil(y + ch));
    const rr = Math.max(0, Math.min(rad, Math.floor(cw / 2), Math.floor(ch / 2)));
    const r2 = rr * rr;

    function inCorner(px, py, cx, cy) {
        const dx = px + 0.5 - cx;
        const dy = py + 0.5 - cy;
        return dx * dx + dy * dy <= r2;
    }

    function insideCard(px, py) {
        if (px < x || px >= x + cw || py < y || py >= y + ch) return false;
        if (px < x + rr && py < y + rr && !inCorner(px, py, x + rr, y + rr)) return false;
        if (px >= x + cw - rr && py < y + rr && !inCorner(px, py, x + cw - rr, y + rr)) return false;
        if (px < x + rr && py >= y + ch - rr && !inCorner(px, py, x + rr, y + ch - rr)) return false;
        if (px >= x + cw - rr && py >= y + ch - rr && !inCorner(px, py, x + cw - rr, y + ch - rr)) return false;
        return true;
    }

    const midLine = y + Math.floor(ch * 0.46);

    for (let py = y0; py < y1; py++) {
        for (let px = x0; px < x1; px++) {
            if (!insideCard(px, py)) continue;
            let r = fr;
            let gch = fg;
            let bpx = fb;
            if (px < x + stripeW) {
                r = sr;
                gch = sg;
                bpx = sb;
            } else if (py < y + topH) {
                r = tr;
                gch = tg;
                bpx = tb;
            }
            if (py === midLine) {
                r = Math.max(0, r - 22);
                gch = Math.max(0, gch - 20);
                bpx = Math.max(0, bpx - 14);
            }
            r = Math.min(255, r + shineAmt);
            gch = Math.min(255, gch + shineAmt);
            bpx = Math.min(255, bpx + shineAmt);
            setPixel(buf, px, py, r, gch, bpx);
        }
    }
}

function smooth01(t) {
    return t * t * (3 - 2 * t);
}

const laneW = 56;
const gap = 10;
const totalW = 3 * laneW + 2 * gap;
const startX = (W - totalW) / 2;
const yBaseline = H - 32;
const laneTop = 72;
const boardRad = 12;
const laneRad = 8;
const cardRad = 8;

const gif = GIFEncoder();

for (let f = 0; f < FRAMES; f++) {
    const buf = new Uint8ClampedArray(W * H * 4);
    fillBgFlat(buf);

    const t = (f / FRAMES) * Math.PI * 2;
    const shinePhase = (f / FRAMES) * (W + 140);
    const shineX = shinePhase - 70;

    const boardX = startX - 12;
    const boardY = laneTop - 22;
    const boardW = totalW + 24;
    const boardH = yBaseline - laneTop + 38;

    fillRoundRect(buf, boardX, boardY, boardW, boardH, boardRad, ...BOARD);
    fillRect(buf, boardX + 2, boardY + 2, boardX + boardW - 2, boardY + 5, ...ACCENT);
    fillRect(buf, boardX + 2, boardY + 5, boardX + boardW - 2, boardY + 21, ...BOARD_HEADER);

    for (let col = 0; col < 2; col++) {
        const gx = startX + (col + 1) * laneW + col * gap + gap / 2;
        fillRect(buf, gx, laneTop + 3, gx + 1, yBaseline + 4, ...DIVIDER);
    }

    for (let col = 0; col < 3; col++) {
        const lx = startX + col * (laneW + gap);
        const hx = lx + laneW / 2 - 4;
        const hy = boardY + 8;
        const pulse = 0.55 + 0.45 * smooth01(0.5 + 0.5 * Math.sin(t * 1.4 + col * 1.2));
        const fv = COLS[col].fill;
        const rv = Math.min(255, Math.round(fv[0] * pulse));
        const gv = Math.min(255, Math.round(fv[1] * pulse));
        const bv = Math.min(255, Math.round(fv[2] * pulse));
        fillRoundRect(buf, hx, hy, 8, 8, MARKER_RAD, rv, gv, bv);
    }

    function shinePass(cx, cw, sx) {
        const cardMid = cx + cw * 0.5;
        const dist = Math.abs(sx - cardMid);
        if (dist > 64) return 0;
        return Math.round((1 - dist / 64) * 14);
    }

    for (let col = 0; col < 3; col++) {
        const lx = startX + col * (laneW + gap);
        fillRoundRect(buf, lx, laneTop, laneW, yBaseline - laneTop + 4, laneRad, ...LANE);

        const colPhase = t + col * ((2 * Math.PI) / 3);
        const u = 0.5 + 0.5 * Math.sin(colPhase);
        const u2 = 0.5 + 0.5 * Math.sin(colPhase * 1.17 + 0.5);
        const u3 = 0.5 + 0.5 * Math.sin(colPhase * 0.89 - 0.3);

        const bob = Math.sin(colPhase * 1.42) * 2.8;
        const bob2 = Math.sin(colPhase * 1.42 + 1.15) * 2;
        const bob3 = Math.sin(colPhase * 1.42 + 2.35) * 1.7;

        const drift = Math.sin(colPhase * 2.05) * 1.8;
        const drift2 = Math.sin(colPhase * 2.05 + 0.7) * 1.2;
        const drift3 = Math.sin(colPhase * 2.05 + 1.4) * 1;

        const cx = lx + 7 + drift;
        const cw = laneW - 14;

        const h3 = 24 + Math.round(10 * u3);
        const h2 = 32 + Math.round(14 * u2);
        const h1 = 42 + Math.round(20 * u);

        const gap12 = 8;
        const gap23 = 7;
        let yTop = yBaseline - h1 + bob;
        drawCardFlat(buf, cx + drift * 0.2, yTop, cw, h1, cardRad, COLS[col], shinePass(cx, cw, shineX));

        yTop -= h2 + gap12 + bob2;
        drawCardFlat(buf, cx + drift2 * 0.25, yTop, cw, h2, cardRad, COLS[col], shinePass(cx, cw, shineX));

        yTop -= h3 + gap23 + bob3;
        drawCardFlat(buf, cx + drift3 * 0.3, yTop, cw, h3, cardRad, COLS[col], shinePass(cx, cw, shineX));
    }

    const palette = quantize(buf, 256);
    const index = applyPalette(buf, palette);
    gif.writeFrame(index, W, H, {
        palette,
        delay: DELAY_MS,
        repeat: f === 0 ? 0 : undefined,
    });
}

gif.finish();
fs.mkdirSync(path.dirname(OUT), { recursive: true });
fs.writeFileSync(OUT, Buffer.from(gif.bytes()));
console.log('Wrote', OUT, `(${FRAMES} frames, flat-modern, ${W}x${H})`);
