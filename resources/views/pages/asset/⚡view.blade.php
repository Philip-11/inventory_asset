<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Asset Inventory Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
:root {
    --sidebar-bg: #0f172a;
    --sidebar-width: 260px;
}

body {
    background: #f1f5f9;
    min-height: 100vh;
}

.sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    min-height: 100vh;
}

.sidebar .nav-link {
    color: #cbd5e1;
    border-radius: 0.5rem;
    padding: 0.7rem 0.9rem;
}

.sidebar .nav-link.active,
.sidebar .nav-link:hover {
    background: rgba(255, 255, 255, 0.08);
    color: #fff;
}

.kpi-card,
.table-card {
    border: 0;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1.25rem rgba(15, 23, 42, 0.06);
}

.icon-badge {
    width: 48px;
    height: 48px;
    border-radius: 0.85rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.1;
}

.sortable {
    cursor: pointer;
    white-space: nowrap;
}

.sortable:hover {
    color: #0d6efd;
}

select option:disabled {
    color: #adb5bd;
}

@media (max-width: 991.98px) {
    .sidebar {
        width: 100%;
        min-height: auto;
    }
}
</style>
</head>
<body>
<div class="d-lg-flex">
<aside class="sidebar p-4 text-white">
<div class="d-flex align-items-center mb-4">
<span class="icon-badge bg-primary me-3"><i class="bi bi-boxes"></i></span>
<div>
<h1 class="h5 mb-0">Asset Inventory</h1>
<small class="text-secondary">Management System</small>
</div>
</div>
<nav class="nav flex-column gap-1">
<a class="nav-link active" href="#dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
<a class="nav-link" href="#inventory"><i class="bi bi-collection me-2"></i>Inventory</a>
</nav>
</aside>

<main class="flex-grow-1 p-4">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
<div>
<h2 class="h3 mb-1">Dashboard</h2>
<p class="text-secondary mb-0">Remaining, added, and deployed counts update with the filters below.</p>
</div>
<span class="badge text-bg-light border px-3 py-2">Sample data</span>
</div>

<section id="dashboard" class="row g-3 mb-4">
<div class="col-md-4">
<div class="card kpi-card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-start">
<div>
<p class="text-secondary mb-1">Assets remaining</p>
<div class="stat-number text-success" id="total-remaining">0</div>
</div>
<span class="icon-badge bg-success-subtle text-success"><i class="bi bi-box-seam"></i></span>
</div>
<small class="text-secondary">Still in stock</small>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card kpi-card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-start">
<div>
<p class="text-secondary mb-1">Assets added</p>
<div class="stat-number text-primary" id="total-added">0</div>
</div>
<span class="icon-badge bg-primary-subtle text-primary"><i class="bi bi-plus-circle"></i></span>
</div>
<small class="text-secondary">Recorded into inventory</small>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card kpi-card">
<div class="card-body">
<div class="d-flex justify-content-between align-items-start">
<div>
<p class="text-secondary mb-1">Assets deployed</p>
<div class="stat-number text-warning" id="total-deployed">0</div>
</div>
<span class="icon-badge bg-warning-subtle text-warning"><i class="bi bi-send-check"></i></span>
</div>
<small class="text-secondary">Assigned to users</small>
</div>
</div>
</div>
</section>

<section id="inventory">
<div class="card table-card">
<div class="card-body">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
<h3 class="h5 mb-0">Inventory</h3>
<small class="text-secondary" id="result-count">0 models</small>
</div>

<form class="row g-3 align-items-end mb-3" id="filter-form">
<div class="col-md-3">
<label class="form-label" for="filter-type">Asset type</label>
<select class="form-select" id="filter-type">
<option value="">All types</option>
</select>
</div>
<div class="col-md-3">
<label class="form-label" for="filter-brand">Brand</label>
<select class="form-select" id="filter-brand">
<option value="">All brands</option>
</select>
</div>
<div class="col-md-2">
<label class="form-label" for="filter-status">Stock status</label>
<select class="form-select" id="filter-status">
<option value="">All</option>
<option value="in-stock">Has remaining</option>
<option value="deployed">Has deployed</option>
<option value="low">Low stock (5 or less)</option>
</select>
</div>
<div class="col-md-4 col-lg-3">
<label class="form-label" for="filter-search">Search</label>
<div class="input-group">
<input class="form-control" id="filter-search" type="search" placeholder="Model or location">
<button class="btn btn-outline-secondary" id="reset-filters" type="button">Reset</button>
</div>
</div>
</form>

<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
<thead>
<tr>
<th class="sortable" data-sort="type">Type <i class="bi bi-arrow-down-up"></i></th>
<th class="sortable" data-sort="brand">Brand <i class="bi bi-arrow-down-up"></i></th>
<th class="sortable" data-sort="model">Model <i class="bi bi-arrow-down-up"></i></th>
<th>Location</th>
<th class="sortable text-end" data-sort="remaining">Remaining <i class="bi bi-arrow-down-up"></i></th>
<th class="sortable text-end" data-sort="added">Added <i class="bi bi-arrow-down-up"></i></th>
<th class="sortable text-end" data-sort="deployed">Deployed <i class="bi bi-arrow-down-up"></i></th>
<th>Status</th>
</tr>
</thead>
<tbody id="asset-table-body"></tbody>
</table>
</div>
<p class="text-secondary text-center py-4 mb-0 d-none" id="empty-state">No assets match the current filters.</p>
</div>
</div>
</section>
</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const assets = [
    { type: "Monitor", brand: "Dell", model: "P2422H", location: "Warehouse A", added: 22, deployed: 8 },
{ type: "Monitor", brand: "HP", model: "E24 G5", location: "Warehouse A", added: 18, deployed: 7 },
{ type: "Monitor", brand: "LG", model: "27UP850", location: "IT Closet", added: 6, deployed: 3 },
{ type: "Headset", brand: "Jabra", model: "Evolve2 40", location: "Warehouse B", added: 18, deployed: 14 },
{ type: "Headset", brand: "Jabra", model: "Evolve2 65", location: "Warehouse B", added: 12, deployed: 9 },
{ type: "Headset", brand: "Logitech", model: "Zone Wired", location: "Reception", added: 20, deployed: 7 },
{ type: "Laptop", brand: "Dell", model: "Latitude 5440", location: "IT Closet", added: 12, deployed: 10 },
{ type: "Laptop", brand: "HP", model: "EliteBook 840", location: "IT Closet", added: 10, deployed: 8 },
{ type: "Laptop", brand: "Lenovo", model: "ThinkPad T14", location: "Warehouse A", added: 8, deployed: 6 },
{ type: "Mouse", brand: "Logitech", model: "MX Master 3S", location: "Warehouse B", added: 15, deployed: 11 },
{ type: "Mouse", brand: "Dell", model: "MS116", location: "Warehouse A", added: 20, deployed: 14 },
{ type: "Mouse", brand: "HP", model: "125", location: "Reception", added: 20, deployed: 8 },
{ type: "Keyboard", brand: "Logitech", model: "MX Keys", location: "Warehouse B", added: 10, deployed: 7 },
{ type: "Keyboard", brand: "Dell", model: "KB216", location: "Warehouse A", added: 24, deployed: 12 },
{ type: "Keyboard", brand: "HP", model: "320K", location: "Reception", added: 14, deployed: 11 }
].map((asset) => ({
    ...asset,
    remaining: asset.added - asset.deployed
}));

const typeSelect = document.getElementById("filter-type");
const brandSelect = document.getElementById("filter-brand");
const statusSelect = document.getElementById("filter-status");
const searchInput = document.getElementById("filter-search");
const tableBody = document.getElementById("asset-table-body");
const emptyState = document.getElementById("empty-state");
const resultCount = document.getElementById("result-count");

let sortKey = "type";
let sortDir = "asc";

const uniqueSorted = (values) => [...new Set(values)].sort((a, b) => a.localeCompare(b));
const types = uniqueSorted(assets.map((asset) => asset.type));
const brands = uniqueSorted(assets.map((asset) => asset.brand));

types.forEach((type) => {
    typeSelect.insertAdjacentHTML("beforeend", `<option value="${type}">${type}</option>`);
});

brands.forEach((brand) => {
    brandSelect.insertAdjacentHTML("beforeend", `<option value="${brand}">${brand}</option>`);
});

function currentFilters() {
    return {
        type: typeSelect.value,
        brand: brandSelect.value,
        status: statusSelect.value,
        search: searchInput.value.trim().toLowerCase()
    };
}

function matchesFilters(asset, filters, ignore = "") {
    if (ignore !== "type" && filters.type && asset.type !== filters.type) return false;
    if (ignore !== "brand" && filters.brand && asset.brand !== filters.brand) return false;
    if (filters.status === "in-stock" && asset.remaining <= 0) return false;
    if (filters.status === "deployed" && asset.deployed <= 0) return false;
    if (filters.status === "low" && asset.remaining > 5) return false;
    if (filters.search) {
        const haystack = `${asset.model} ${asset.location} ${asset.brand} ${asset.type}`.toLowerCase();
        if (!haystack.includes(filters.search)) return false;
    }
    return true;
}

function updateDisabledOptions() {
    const filters = currentFilters();
    const typeMatches = assets.filter((asset) => matchesFilters(asset, filters, "type"));
    const brandMatches = assets.filter((asset) => matchesFilters(asset, filters, "brand"));
    const availableTypes = new Set(typeMatches.map((asset) => asset.type));
    const availableBrands = new Set(brandMatches.map((asset) => asset.brand));

    [...typeSelect.options].forEach((option) => {
        if (!option.value) return;
        option.disabled = option.value !== filters.type && !availableTypes.has(option.value);
    });

    [...brandSelect.options].forEach((option) => {
        if (!option.value) return;
        option.disabled = option.value !== filters.brand && !availableBrands.has(option.value);
    });
}

function stockBadge(asset) {
    if (asset.remaining <= 0) {
        return '<span class="badge text-bg-secondary">Fully deployed</span>';
    }
    if (asset.remaining <= 5) {
        return '<span class="badge text-bg-danger">Low stock</span>';
    }
    return '<span class="badge text-bg-success">In stock</span>';
}

function render() {
    const filters = currentFilters();
    const rows = assets
    .filter((asset) => matchesFilters(asset, filters))
    .sort((a, b) => {
        const left = a[sortKey];
        const right = b[sortKey];
        const result = typeof left === "number" ? left - right : String(left).localeCompare(String(right));
        return sortDir === "asc" ? result : -result;
    });

    const totals = rows.reduce(
        (acc, asset) => {
            acc.remaining += asset.remaining;
            acc.added += asset.added;
            acc.deployed += asset.deployed;
            return acc;
        },
        { remaining: 0, added: 0, deployed: 0 }
    );

    document.getElementById("total-remaining").textContent = totals.remaining;
    document.getElementById("total-added").textContent = totals.added;
    document.getElementById("total-deployed").textContent = totals.deployed;
    resultCount.textContent = `${rows.length} model${rows.length === 1 ? "" : "s"}`;

    tableBody.innerHTML = rows.map((asset) => `
    <tr>
    <td>${asset.type}</td>
    <td>${asset.brand}</td>
    <td>${asset.model}</td>
    <td>${asset.location}</td>
    <td class="text-end fw-semibold text-success">${asset.remaining}</td>
    <td class="text-end text-primary">${asset.added}</td>
    <td class="text-end text-warning">${asset.deployed}</td>
    <td>${stockBadge(asset)}</td>
    </tr>
    `).join("");

    emptyState.classList.toggle("d-none", rows.length > 0);
    tableBody.closest("table").classList.toggle("d-none", rows.length === 0);
    updateDisabledOptions();
}

["change", "input"].forEach((eventName) => {
    document.getElementById("filter-form").addEventListener(eventName, render);
});

document.getElementById("reset-filters").addEventListener("click", () => {
    typeSelect.value = "";
    brandSelect.value = "";
    statusSelect.value = "";
    searchInput.value = "";
    sortKey = "type";
    sortDir = "asc";
    render();
});

document.querySelectorAll(".sortable").forEach((header) => {
    header.addEventListener("click", () => {
        const nextKey = header.dataset.sort;
        if (sortKey === nextKey) {
            sortDir = sortDir === "asc" ? "desc" : "asc";
        } else {
            sortKey = nextKey;
            sortDir = "asc";
        }
        render();
    });
});

render();
</script>
</body>
</html>
