<style>
    :root {
        --bg: #f1f2f4;
        --surface: #fff;
        --border: #e3e5e8;
        --text-primary: #202223;
        --text-secondary: #6d7175;
        --text-hint: #8c9196;
        --accent: #303d89;
        --accent-light: #f0f1fc;
        --green: #007a5e;
        --green-bg: #e3f1ec;
        --red: #b22222;
        --red-bg: #fce8e8;
        --blue: #0069d9;
        --blue-bg: #e8f2ff;
        --purple: #6d28d9;
        --purple-bg: #ede9fe;
        --amber: #916a00;
        --amber-bg: #fff5cc;
        --radius-sm: 8px;
        --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .home-page {
        background: var(--bg);
        padding: 24px 28px;
        min-height: 100vh;
        font-family: var(--font);
        color: var(--text-primary)
    }

    .home-page * {
        box-sizing: border-box
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px
    }

    .page-header h1 {
        font-size: 20px;
        font-weight: 650;
        margin: 0
    }

    .crumb {
        font-size: 12.5px;
        color: var(--text-hint);
        margin-top: 3px
    }

    .crumb a {
        color: var(--accent);
        text-decoration: none
    }

    .crumb a:hover {
        text-decoration: underline
    }

    .crumb span {
        margin: 0 5px
    }

    .btn-primary-dash,
    .btn-secondary-dash {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: var(--radius-sm);
        padding: 8px 16px;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none !important;
        font-family: var(--font);
        transition: background .15s
    }

    .btn-primary-dash {
        background: var(--accent);
        color: #fff !important;
        border: none;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(48, 61, 137, .25)
    }

    .btn-primary-dash:hover:not(:disabled) {
        background: #252f70
    }

    .btn-primary-dash:disabled {
        opacity: .65;
        cursor: not-allowed
    }

    .btn-secondary-dash {
        background: var(--surface);
        color: var(--text-primary) !important;
        border: 1px solid var(--border);
        font-weight: 500
    }

    .btn-secondary-dash:hover {
        background: var(--bg)
    }

    .cat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        overflow: hidden
    }

    .cat-table-wrap {
        overflow-x: auto
    }

    .cat-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px
    }

    .cat-table thead th {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--text-hint);
        padding: 10px 16px;
        border-bottom: 1px solid var(--border);
        background: #fafafa;
        text-align: left;
        white-space: nowrap
    }

    .cat-table tbody tr {
        border-bottom: 1px solid var(--border)
    }

    .cat-table tbody tr:last-child {
        border-bottom: none
    }

    .cat-table tbody tr:hover {
        background: #fafbfc
    }

    .cat-table tbody td {
        padding: 12px 16px;
        vertical-align: middle
    }

    .cat-pagination {
        padding: 14px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: center
    }

    .id-chip {
        display: inline-block;
        background: var(--bg);
        color: var(--text-secondary);
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px
    }

    .thumb {
        height: 42px;
        width: auto;
        max-width: 110px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border)
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        white-space: nowrap
    }

    .pill::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%
    }

    .pill-active {
        background: var(--green-bg);
        color: var(--green)
    }

    .pill-active::before {
        background: var(--green)
    }

    .pill-inactive {
        background: var(--red-bg);
        color: var(--red)
    }

    .pill-inactive::before {
        background: var(--red)
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-secondary);
        font-size: 12px;
        cursor: pointer;
        text-decoration: none
    }

    .action-btn:hover {
        background: var(--bg);
        color: var(--text-primary)
    }

    .action-btn-danger:hover {
        background: var(--red-bg);
        border-color: #f5c6c6;
        color: var(--red)
    }

    .empty-state {
        text-align: center;
        padding: 64px 20px
    }

    .empty-state p {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 6px 0 16px
    }

    .flash-ok {
        background: var(--green-bg);
        color: var(--green);
        border: 1px solid #bfe0d3;
        border-radius: var(--radius-md);
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 16px
    }

    /* Forms */
    .edit-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 20px;
        align-items: start
    }

    @media(max-width:900px) {
        .edit-layout {
            grid-template-columns: 1fr
        }
    }

    .section-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 16px
    }

    .section-card-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        background: #fafafa
    }

    .section-card-header h5 {
        font-size: 13px;
        font-weight: 650;
        margin: 0
    }

    .section-card-body {
        padding: 20px
    }

    .field-flex {
        display: flex;
        flex-wrap: wrap;
        column-gap: 16px
    }

    .fg-full {
        flex: 0 0 100%
    }

    .fg-half {
        flex: 0 0 calc(50% - 8px)
    }

    @media(max-width:700px) {
        .fg-half {
            flex: 0 0 100%
        }
    }

    .field-group {
        margin-bottom: 16px
    }

    .field-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        letter-spacing: .03em;
        text-transform: uppercase;
        margin-bottom: 6px
    }

    .field-label .req {
        color: var(--red);
        margin-left: 2px
    }

    .field-input,
    .field-select,
    .field-textarea {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0 12px;
        font-size: 13.5px;
        color: var(--text-primary);
        background: var(--surface);
        outline: none;
        font-family: var(--font);
        transition: border-color .15s, box-shadow .15s
    }

    .field-input,
    .field-select {
        height: 38px
    }

    .field-textarea {
        padding: 10px 12px
    }

    .field-input:focus,
    .field-select:focus,
    .field-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(48, 61, 137, .12)
    }

    .field-hint {
        font-size: 11.5px;
        color: var(--text-hint);
        margin-top: 4px
    }

    .field-error {
        font-size: 12px;
        color: var(--red);
        margin-top: 4px
    }

    .img-preview {
        display: block;
        max-height: 110px;
        border-radius: 8px;
        border: 1px solid var(--border);
        margin-bottom: 8px
    }

    .switch-line {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        cursor: pointer
    }

    .action-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        padding: 14px 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px
    }

    @media(max-width:768px) {
        .home-page {
            padding: 16px
        }
    }
</style>