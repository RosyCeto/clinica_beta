<h3>Resultados de Laboratorio</h3>
<table class="table">
    <thead>
        <tr>
            <th>Nombre de la Prueba</th>
            <th>Resultados</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laboratories as $lab)
        <tr>
            <td>{{ $lab->lab_test_name }}</td>
            <td>{{ $lab->results }}</td>
            <td>{{ $lab->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('laboratories.edit', $lab->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('laboratories.destroy', $lab->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>