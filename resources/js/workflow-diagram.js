/**
 * Workflow diagram powered by Cytoscape.js + dagre layout.
 * Expects window.workflowDiagramData = { statusesData, transitionsData, container }
 * and sets window.renderWorkflowDiagram(), window.highlightTransition().
 */
import cytoscape from 'cytoscape';
import dagre from 'cytoscape-dagre';

cytoscape.use(dagre);

const LINK_COLORS = ['#2563eb', '#059669', '#b45309', '#7c3aed', '#be123c', '#0d9488'];

let cy = null;

function getData() {
  const d = window.workflowDiagramData || {};
  const statusesData = d.statusesData || [];
  const transitionsData = d.transitionsData || [];
  const container = d.container || '#workflow-cy';
  return { statusesData, transitionsData, container };
}

const NODE_WIDTH = 110;
const NODE_HEIGHT = 40;
const GAP_X = 52;
const GAP_Y = 60;

function buildElements(statusesData, transitionsData) {
  const normalizeId = (v) => (v == null ? null : String(v));
  const statusById = new Map();
  (statusesData || []).forEach((s) => {
    const id = normalizeId(s && s.id);
    if (id !== null) statusById.set(id, s);
  });
  // Sequence = order of first appearance in the transition list (Defined transitions = workflow setup order)
  const sequence = [];
  const seen = new Set();
  (transitionsData || []).forEach((t) => {
    [t.from_status_id, t.to_status_id].forEach((rawId) => {
      const id = normalizeId(rawId);
      if (id != null && !seen.has(id)) {
        seen.add(id);
        sequence.push(id);
      }
    });
  });
  // Fallback: if status list keys don't match transition keys, build lightweight statuses from transitions.
  const orderedStatuses = sequence
    .map((id) => statusById.get(id))
    .filter(Boolean);
  if (orderedStatuses.length === 0 && transitionsData.length > 0) {
    const fallback = [];
    const fallbackSeen = new Set();
    transitionsData.forEach((t) => {
      const fromId = normalizeId(t.from_status_id);
      const toId = normalizeId(t.to_status_id);
      const fromStatus = t.from_status || t.fromStatus || {};
      const toStatus = t.to_status || t.toStatus || {};
      if (fromId && !fallbackSeen.has(fromId)) {
        fallbackSeen.add(fromId);
        fallback.push({ id: fromId, name: fromStatus.name || `Status ${fromId}`, color: fromStatus.color || '#6c757d' });
      }
      if (toId && !fallbackSeen.has(toId)) {
        fallbackSeen.add(toId);
        fallback.push({ id: toId, name: toStatus.name || `Status ${toId}`, color: toStatus.color || '#6c757d' });
      }
    });
    orderedStatuses.push(...fallback);
  }
  const nodes = orderedStatuses.map((s, i) => ({
    data: {
      id: `status-${normalizeId(s.id)}`,
      label: (s.name || '').replace(/</g, '&lt;').replace(/&/g, '&amp;'),
      color: s.color || '#6c757d',
    },
    position: { x: i * (NODE_WIDTH + GAP_X), y: 0 },
  }));
  const edges = (transitionsData || []).map((t, i) => ({
    data: {
      id: `edge-${t.id}`,
      source: `status-${normalizeId(t.from_status_id)}`,
      target: `status-${normalizeId(t.to_status_id)}`,
      transitionId: t.id,
      label: (t.transition_name || '').trim().substring(0, 28),
      color: LINK_COLORS[i % LINK_COLORS.length],
    },
  }));
  return { nodes, edges };
}

function render() {
  const { statusesData, transitionsData, container } = getData();
  const el = document.querySelector(container);
  if (!el) return;

  if (cy) {
    cy.destroy();
    cy = null;
  }

  if (!transitionsData || transitionsData.length === 0) {
    const emptyMsg = document.querySelector('#workflow-diagram-wrap .workflow-empty-msg');
    if (emptyMsg) emptyMsg.style.display = '';
    return;
  }

  const emptyMsg = document.querySelector('#workflow-diagram-wrap .workflow-empty-msg');
  if (emptyMsg) emptyMsg.style.display = 'none';

  const { nodes, edges } = buildElements(statusesData, transitionsData);
  if (nodes.length === 0) return;

  cy = cytoscape({
    container: el,
    elements: [...nodes, ...edges],
    style: [
      {
        selector: 'node',
        style: {
          'label': 'data(label)',
          'text-valign': 'center',
          'text-halign': 'center',
          'font-size': '13px',
          'font-weight': '600',
          'color': '#fff',
          'text-max-width': '100px',
          'text-wrap': 'ellipsis',
          'background-color': 'data(color)',
          'width': 110,
          'height': 40,
          'shape': 'round-rectangle',
          'border-width': 1.5,
          'border-color': 'rgba(0,0,0,0.12)',
          'border-opacity': 1,
          'padding': '4px',
        },
      },
      {
        selector: 'edge',
        style: {
          'width': 1.5,
          'line-color': 'data(color)',
          'target-arrow-color': 'data(color)',
          'target-arrow-shape': 'triangle',
          'curve-style': 'bezier',
          'arrow-scale': 0.9,
        },
      },
      {
        selector: 'edge.highlight',
        style: {
          'width': 2.5,
          'line-color': 'data(color)',
          'target-arrow-color': 'data(color)',
          'z-index': 999,
        },
      },
    ],
    layout: { name: 'preset', fit: true, padding: 20 },
    minZoom: 0.3,
    maxZoom: 2.5,
    wheelSensitivity: 0.3,
  });

  cy.on('tap', 'edge', function (evt) {
    const tid = evt.target.data('transitionId');
    if (tid != null && window.highlightTransition) {
      window.highlightTransition(tid, true);
      setTimeout(() => window.highlightTransition(tid, false), 1500);
    }
  });
  cy.on('mouseover', 'edge', function (evt) {
    const tid = evt.target.data('transitionId');
    if (tid != null && window.highlightTransition) window.highlightTransition(tid, true);
  });
  cy.on('mouseout', 'edge', function (evt) {
    const tid = evt.target.data('transitionId');
    if (tid != null && window.highlightTransition) window.highlightTransition(tid, false);
  });
}

function highlightTransition(transitionId, on) {
  if (!cy) return;
  const edge = cy.getElementById(`edge-${transitionId}`);
  if (edge.length) edge.toggleClass('highlight', on);
}

// Expose for the inline script (transition list hover, add/remove/reorder)
window.renderWorkflowDiagram = render;
window.workflowDiagramHighlightEdge = highlightTransition;

// Auto-run when DOM is ready (data is set by inline script before this module runs)
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', render);
} else {
  render();
}
