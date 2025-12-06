<style>
/* Skeleton Editor Styles */

/* Content nodes in skeleton view */
[data-content-key] {
    position: relative;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    border-radius: 4px;
    padding: 2px 4px;
    margin: 1px;
    min-height: 20px;
    display: inline-block;
}

/* Text content nodes */
[data-content-key][data-content-type="text"] {
    background: rgba(59, 130, 246, 0.1);
    border-color: rgba(59, 130, 246, 0.3);
}

[data-content-key][data-content-type="text"]:hover {
    background: rgba(59, 130, 246, 0.2);
    border-color: rgba(59, 130, 246, 0.6);
    transform: scale(1.02);
}

/* Image content nodes */
[data-content-key][data-content-type="image"] {
    background: rgba(34, 197, 94, 0.1);
    border-color: rgba(34, 197, 94, 0.3);
}

[data-content-key][data-content-type="image"]:hover {
    background: rgba(34, 197, 94, 0.2);
    border-color: rgba(34, 197, 94, 0.6);
    transform: scale(1.02);
}

/* Content updated animation */
.content-updated {
    animation: contentUpdate 2s ease-out;
}

@keyframes contentUpdate {
    0% {
        background: rgba(34, 197, 94, 0.4);
        border-color: rgba(34, 197, 94, 0.8);
        transform: scale(1.05);
    }
    100% {
        background: transparent;
        border-color: transparent;
        transform: scale(1);
    }
}

/* Hover tooltip */
[data-content-key]:hover::before {
    content: attr(data-content-key) ' (' attr(data-content-type) ')';
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    white-space: nowrap;
    z-index: 1000;
    pointer-events: none;
}

/* Hover tooltip arrow */
[data-content-key]:hover::after {
    content: '';
    position: absolute;
    top: -6px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 6px solid rgba(0, 0, 0, 0.9);
    z-index: 1000;
    pointer-events: none;
}

/* Skeleton page specific styles */
.skeleton-editor {
    background: #0f0f0f;
    min-height: 100vh;
    color: #fff;
}

.skeleton-header {
    background: rgba(23, 23, 23, 0.9);
    border-bottom: 1px solid #374151;
    padding: 1rem 2rem;
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(8px);
}

.skeleton-nav {
    position: sticky;
    top: 80px; /* Below the header */
    z-index: 99;
    backdrop-filter: blur(8px);
}

.skeleton-content {
    padding: 2rem;
}

/* Section headers */
.section-header {
    border-bottom: 2px solid rgba(156, 163, 175, 0.3);
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
}

.section-header h2 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Section highlight animation */
.bg-white\/10 {
    background-color: rgba(255, 255, 255, 0.1) !important;
    transition: background-color 2s ease-out;
}

/* Completion summary */
.completion-summary {
    margin-top: 2rem;
    animation: fadeInUp 1s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mode indicator */
.skeleton-mode-indicator {
    position: fixed;
    top: 20px;
    right: 20px;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    z-index: 1001;
    backdrop-filter: blur(4px);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Skeleton instructions */
.skeleton-instructions {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.3);
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 24px;
    color: #ddd;
}

.skeleton-instructions h3 {
    color: #60a5fa;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 600;
}

.skeleton-instructions ul {
    list-style: disc;
    margin-left: 20px;
    font-size: 13px;
    line-height: 1.5;
}

.skeleton-instructions li {
    margin-bottom: 4px;
}

/* Empty content placeholder */
[data-content-key]:empty::before {
    content: '[Click to edit: ' attr(data-content-key) ']';
    color: #9ca3af;
    font-style: italic;
    font-size: 12px;
}

/* Content type badges in skeleton */
.content-type-badge {
    display: inline-block;
    background: rgba(75, 85, 99, 0.8);
    color: #e5e7eb;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 500;
    margin-left: 4px;
    vertical-align: super;
}

/* Text content badge */
[data-content-type="text"] .content-type-badge {
    background: rgba(59, 130, 246, 0.8);
    color: #dbeafe;
}

/* Image content badge */
[data-content-type="image"] .content-type-badge {
    background: rgba(34, 197, 94, 0.8);
    color: #dcfce7;
}

/* Loading overlay for skeleton */
.skeleton-loading {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.skeleton-loading .spinner {
    width: 40px;
    height: 40px;
    border: 4px solid rgba(239, 68, 68, 0.3);
    border-top: 4px solid #ef4444;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .skeleton-header {
        padding: 1rem 1.5rem;
    }
    
    .skeleton-header > div {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .skeleton-header > div > div:last-child {
        width: 100%;
        flex-wrap: wrap;
    }
    
    .skeleton-content {
        padding: 1.5rem;
    }
    
    .skeleton-nav {
        padding: 0.75rem 1rem;
    }
    
    .skeleton-nav > div {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .skeleton-nav a {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
    }
}

@media (max-width: 768px) {
    .skeleton-header {
        padding: 1rem;
        position: relative;
    }
    
    .skeleton-header h1 {
        font-size: 1.125rem !important;
        line-height: 1.4;
    }
    
    .skeleton-header p {
        font-size: 0.75rem !important;
    }
    
    .skeleton-header > div > div:last-child {
        flex-direction: column;
        width: 100%;
    }
    
    .skeleton-header > div > div:last-child a,
    .skeleton-header > div > div:last-child button {
        width: 100%;
        text-align: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .skeleton-content {
        padding: 1rem;
    }
    
    .skeleton-nav {
        padding: 0.5rem;
        position: relative;
        top: 0;
    }
    
    .skeleton-nav > div {
        gap: 0.375rem;
    }
    
    .skeleton-nav a {
        font-size: 0.7rem;
        padding: 0.375rem 0.5rem;
    }
    
    .skeleton-mode-indicator {
        top: 10px;
        right: 10px;
        font-size: 10px;
        padding: 6px 12px;
    }
    
    .skeleton-instructions {
        padding: 12px;
        font-size: 0.875rem;
    }
    
    .skeleton-instructions h3 {
        font-size: 0.875rem;
    }
    
    .skeleton-instructions ul {
        font-size: 0.75rem;
        margin-left: 16px;
    }
    
    /* Section responsive */
    section {
        padding: 1.5rem 1rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .section-header {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
    }
    
    .section-header h2 {
        font-size: 1.25rem !important;
        flex-wrap: wrap;
    }
    
    .section-header p {
        font-size: 0.75rem !important;
    }
    
    /* Hero section responsive */
    .hero .container {
        padding: 0;
    }
    
    .hero .grid {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    .hero h1 {
        font-size: 1.75rem !important;
    }
    
    .hero h2 {
        font-size: 1.25rem !important;
    }
    
    .hero p {
        font-size: 1rem !important;
    }
    
    .countdown {
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.75rem !important;
        padding: 0.75rem !important;
    }
    
    .countdown > div {
        min-width: 60px;
    }
    
    .countdown .text-2xl {
        font-size: 1.5rem !important;
    }
    
    /* Services section responsive */
    .services .grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .services h2 {
        font-size: 1.5rem !important;
    }
    
    /* Tournaments section responsive */
    .tournaments .grid {
        grid-template-columns: 1fr !important;
    }
    
    .tournaments h2 {
        font-size: 1.5rem !important;
    }
    
    /* Partners section responsive */
    .partners .grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .partners h2 {
        font-size: 1.5rem !important;
    }
    
    /* Testimonials section responsive */
    .testimonials .grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .testimonials .section-header > div {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .testimonials .section-header a {
        width: 100%;
        text-align: center;
    }
    
    /* About section responsive */
    .about .grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .about h2 {
        font-size: 1.5rem !important;
    }
    
    .about .max-w-md {
        max-width: 100%;
    }
    
    .about .flex {
        flex-direction: column;
    }
    
    .about input[type="email"] {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .about button {
        width: 100%;
    }
    
    /* Completion summary responsive */
    .completion-summary {
        padding: 1rem !important;
    }
    
    .completion-summary .grid {
        grid-template-columns: 1fr !important;
        gap: 0.5rem !important;
    }
    
    .completion-summary h3 {
        font-size: 1rem !important;
    }
    
    .completion-summary p {
        font-size: 0.875rem !important;
    }
    
    [data-content-key]:hover::before {
        font-size: 10px;
        padding: 2px 6px;
        max-width: 200px;
        word-wrap: break-word;
        white-space: normal;
    }
}

@media (max-width: 480px) {
    .skeleton-header {
        padding: 0.75rem;
    }
    
    .skeleton-header h1 {
        font-size: 1rem !important;
    }
    
    .skeleton-content {
        padding: 0.75rem;
    }
    
    .skeleton-nav a {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
    }
    
    section {
        padding: 1rem 0.75rem !important;
    }
    
    .section-header h2 {
        font-size: 1.125rem !important;
    }
    
    .hero h1 {
        font-size: 1.5rem !important;
    }
    
    .hero h2 {
        font-size: 1.125rem !important;
    }
    
    .countdown {
        gap: 0.5rem !important;
        padding: 0.5rem !important;
    }
    
    .countdown > div {
        min-width: 50px;
    }
    
    .countdown .text-2xl {
        font-size: 1.25rem !important;
    }
    
    .services h2,
    .tournaments h2,
    .partners h2,
    .about h2 {
        font-size: 1.25rem !important;
    }
    
    .completion-summary {
        padding: 0.75rem !important;
    }
    
    .completion-summary h3 {
        font-size: 0.875rem !important;
    }
}

/* Dark mode optimizations */
@media (prefers-color-scheme: dark) {
    [data-content-key]:hover::before {
        background: rgba(255, 255, 255, 0.9);
        color: black;
    }
    
    [data-content-key]:hover::after {
        border-top-color: rgba(255, 255, 255, 0.9);
    }
}

/* Print styles (hide editing elements when printing) */
@media print {
    [data-content-key] {
        border: none !important;
        background: transparent !important;
        cursor: default !important;
    }
    
    [data-content-key]:hover::before,
    [data-content-key]:hover::after,
    .skeleton-mode-indicator,
    .skeleton-instructions {
        display: none !important;
    }
}
</style>