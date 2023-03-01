    <style>
        .note-editor {
            margin-bottom: 0;
        }

        .note-editor.is-invalid {
            border-color: var(--danger);
        }

        .bg-header-hijau {
            /* background-color: #26a839 !important; */
            background-color: #31c447 !important;

        }

        .bg-sidebar-hijau {
            background-color: #1ea733 !important;
        }

        a:hover {
            color: #028316;
            text-decoration: none;
            background-color: transparent;
        }

        a {
            color: #028316;
            text-decoration: none;
            background-color: transparent;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            /* background-color: #028316 !important; */
            background-color: #0d9c23 !important;
        }

        .nav-pills .nav-link {
            color: #028316;
        }

        .nav-sidebar .nav-item .nav-link:hover {
            color: #49da5f;
        }

        .img-thumbnail:hover {
            -webkit-transform: scale(1.08);
            transform: scale(1.08);
        }
    </style>

    @push('scripts')
    @endpush
