@props(['type' => null, 'message' => null])

@php
    if (!$message) {
        $sessionMessages = [
            'success' => session()->pull('success'), // pull para remover a mensagem da sessão
            'error' => session()->pull('error'),
            'warning' => session()->pull('warning'),
            'info' => session()->pull('info'),
            'status' => session()->pull('status'),
        ];
        foreach ($sessionMessages as $key => $msg) {
            if ($msg) {
                $type = $key;
                $message = $msg;
                break;
            }
        }
    }

    $alertIcons = [
        'success' => 'success',
        'error' => 'error',
        'warning' => 'warning',
        'info' => 'info',
        'status' => 'info',
    ];

    $icon = $alertIcons[$type] ?? 'info';
@endphp

@if ($message)
    <script>
        window.addEventListener('pageshow', function(event) {
            const skip = sessionStorage.getItem("skipSwalSuccess");

            // Se vier do cache ou marcado como ignorar, não mostra alerta
            if ((event.persisted || skip === "1") && @json($type) === 'success') {
                sessionStorage.removeItem("skipSwalSuccess");
                return;
            }

            sessionStorage.removeItem("skipSwalSuccess"); // limpa sempre para evitar efeitos colaterais

            const isDark = document.documentElement.classList.contains("dark");

            Swal.fire({
                title: @json(ucfirst($type)),
                text: @json($message),
                icon: @json($icon),
                confirmButtonText: "OK",
                confirmButtonColor: "#32a2b9",
                background: isDark ? "#1f2937" : "#fff",
                color: isDark ? "#f9fafb" : "#111827",
            });
        });
    </script>
@endif
