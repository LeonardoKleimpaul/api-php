const token = 'myGfrUyXGhg6620795ad5528';
const url = 'http://localhost:8080/';
const headers = {
  'Content-Type': 'application/json',
  Authorization: `Bearer ${token}`,
};

document.addEventListener('DOMContentLoaded', () => {
  listarUsuarios();
  const createForm = document.getElementById('create-form');

  if(createForm) {
    createForm.addEventListener('submit', (e) => {
      e.preventDefault();
      enviarDados(e);
    });
  }
});

async function enviarDados(form) {
  if (form.target.name && form.target.email) {
    try {

      const dados = {
        nome: form.target.name.value,
        email: form.target.email.value,
      };

      const response = await fetch(url + 'usuarios/cadastrar', {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(dados),
      });

      const data = await response.json();

      if(data.resposta.id_inserido){
        document.getElementById('create-btn-close').click();
        listarUsuarios();
      }

    } catch (error) {
      console.error(error);
    }
  }
}

async function listarUsuarios() {
  let data = await fetchData('usuarios/listar');

  if (data.tipo == 'sucesso') {
    let usuarios = data.resposta;

    usuarios.forEach((e) => {
      let table = document.getElementById('usuariosTable');
      let existingRow = table ? table.querySelector(`tr[data-id="${e.id}"]`) : null;

      if (existingRow) {
        let cells = existingRow.cells;
        cells[1].innerHTML = e.nome;
        cells[2].innerHTML = e.email;
        cells[3].innerHTML = e.status == true ? 'Ativo' : 'Inativo';
      } else if (table) {
        let row = table.insertRow();
        row.setAttribute('data-id', e.id);
        let cell1 = row.insertCell(0);
        let cell2 = row.insertCell(1);
        let cell3 = row.insertCell(2);
        let cell4 = row.insertCell(3);
        let cell5 = row.insertCell(4);

        cell1.innerHTML = e.id;
        cell2.innerHTML = e.nome;
        cell3.innerHTML = e.email;
        cell4.innerHTML = e.status == true ? 'Ativo' : 'Inativo';
        cell5.innerHTML = `<button data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-sm btn-primary" onclick="editarUsuario(${e.id})">Editar</button>
                <button class="btn btn-sm btn-danger" onclick="excluirUsuario(${e.id})">Excluir</button>`;
      }
    });
  }
}

async function editarUsuario($id) {
  let data = await fetchData('usuarios/listar/' + $id);

  if (data.tipo == 'sucesso') {
    let usuario = data.resposta;

    document.getElementById('edit-name').value = usuario.nome;
    document.getElementById('edit-email').value = usuario.email;
  }
}

async function fetchData(rota) {
  try {
    const response = await fetch(url + rota, {
      method: 'GET',
      headers: headers,
    });

    const data = await response.json();
    return await data;
  } catch (error) {
    console.error(error);
  }
}