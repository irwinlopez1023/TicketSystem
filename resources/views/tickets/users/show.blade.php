<x-bootstrap>
    <div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-sm mb-3">
                <div class="card-body py-3">

                    {{-- Título --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            {{ $ticket->title }}
                        </h5>
                        <x-badge :priority="$ticket->priority" :color="$ticket->priorityColor" :text="$ticket->priorityLabel"></x-badge>
                    </div>

                    <div class="mt-2 small text-muted d-flex flex-wrap gap-3">
                        <span>
                            <i class="bi bi-folder2-open"></i>
                            {{ $ticket->category->name }}
                        </span>
                        <span>
                            <i class="bi bi-person"></i>
                            {{ $ticket->user->name }}
                        </span>

                        <span>
                            <i class="bi bi-clock"></i>
                            {{ $ticket->created_at->diffForHumans() }}
                        </span>
                    </div>

                </div>
            </div>

            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <strong>Problema</strong>
                </div>
                <div class="card-body">
                    {{ $ticket->description }}
                </div>
            </div>

            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <strong>Respuestas</strong>
                </div>
                <div class="card-body">
                        <p class="text-muted">No hay respuestas aún.</p>
                </div>
            </div>

            @can('tickets.reply')
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <strong>Responder</strong>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('user.tickets.create', $ticket) }}">
                            @csrf

                            <div class="mb-3">
                                <textarea
                                    class="form-control"
                                    name="message"
                                    rows="4"
                                    required
                                    minlength="5"
                                    placeholder="Escribe tu respuesta..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Enviar respuesta
                            </button>
                        </form>

                    </div>
                </div>
            @endcan

        </div>
    </div>
</div>

</x-bootstrap>
