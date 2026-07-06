<style>
    /* Custom Select2 Styling */
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        background-color: var(--color-surface, #ffffff);
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        height: 42px;
        display: flex;
        align-items: center;
        position: relative;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1f2937;
        font-size: 0.875rem;
        padding-left: 0.75rem;
        padding-right: 2rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 8px;
    }
    .select2-dropdown {
        background-color: #ffffff;
        border-color: #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        z-index: 1050;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
        background-color: #f9fafb;
        color: #1f2937;
        font-size: 0.875rem;
        padding: 6px 10px;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6;
        color: white;
    }
    .select2-container--default .select2-results__option {
        font-size: 0.875rem;
        padding: 8px 12px;
        color: #1f2937;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #9ca3af;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear {
        position: absolute;
        right: 32px;
        top: 50%;
        transform: translateY(-50%);
        height: auto;
        padding: 0;
        margin: 0;
        font-size: 1.25rem;
        color: #9ca3af;
        z-index: 2;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear:hover {
        color: #ef4444;
    }
    /* Hide default scrollbar to look cleaner */
    .select2-container--default .select2-results > .select2-results__options {
        max-height: 250px;
        overflow-y: auto;
    }
</style>
