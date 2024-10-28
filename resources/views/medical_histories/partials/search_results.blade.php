@if($patients->isNotEmpty())
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>CUI</th>
                <th>N° Expediente</th>
                <th>Nombre Completo</th>
                <th>Consulta</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                @foreach($patient->medicalHistories as $history)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->cui }}</td>
                        <td>{{ $patient->nexpedientes }}</td>
                        <td>{{ $patient->primer_nombre }} {{$patient->segundo_nombre}} {{ $patient->primer_apellido }} {{ $patient->segundo_apellido }}</td>
                        <td>{{ $history->type_consult }}</td>
                        <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('medical_histories.show_pdf', $history->id) }}" class="btn btn-secondary" title="Ver PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>

                            <a href="{{ route('medical_histories.edit', $history->id) }}" class="btn btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('medical_histories.destroy', $history->id) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                            <a href="{{ route('medical_histories.create', ['patient_id' => $patient->id]) }}" class="btn btn-success" title="Crear Nuevo Registro">
                                <i class="fas fa-plus"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <!-- Script de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Evitar el envío automático del formulario

            Swal.fire({
                title: '¿Está seguro que quiere eliminar este registro de historia médica?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Envía el formulario si el usuario confirma
                }
            });
        }
    </script>

    <!-- Enlaces de paginación -->
    <div class="mt-4">
        {{ $patients->appends(request()->query())->links() }}
    </div>
@else
    <div class="alert alert-warning">No se encontraron pacientes.</div>
@endif
