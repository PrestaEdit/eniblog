<template>
  <div class="ui-kit">
    <table class="table">
  <thead class="with-filters">
    <tr class="column-headers">
      <th></th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Username</th>
    </tr>
    <tr class="column-filters">
      <td></td>
      <th>
        <input
          type="text"
          class="form-control"
          placeholder="Search first name"
          name="search_first_name"
          value=""
        />
      </th>
      <th>
        <input
          type="text"
          class="form-control"
          placeholder="Search last name"
          name="search_last_name"
          value=""
        />
      </th>
      <th>
        <input
          type="text"
          class="form-control"
          placeholder="Search username"
          name="search_user_name"
          value=""
        />
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="form-group">
        <div class="md-checkbox md-checkbox-inline">
          <label>
            <input type="checkbox" name="checkbox[]" checked />
            <i class="md-checkbox-control"></i>
          </label>
        </div>
      </td>
      <td>Mark</td>
      <td class="active">Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <td class="form-group">
        <div class="md-checkbox md-checkbox-inline">
          <label>
            <input type="checkbox" name="checkbox[]" checked disabled />
            <i class="md-checkbox-control"></i>
          </label>
        </div>
      </td>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <td class="form-group">
        <div class="md-checkbox md-checkbox-inline">
          <label>
            <input type="checkbox" name="checkbox[]" />
            <i class="md-checkbox-control"></i>
          </label>
        </div>
      </td>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>
  </div>
</template>

<script>
export default {
  name: 'UIKit',
  props: {
    msg: String
  }
}
</script>