<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard - Grades Overview</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      display: flex;
      background-color: #fafafa;
      color: #222;
    }

    /* Sidebar */
    .sidebar {
      width: 70px;
      background: #fff;
      border-right: 1px solid #eee;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 0;
      gap: 25px;
    }

    .sidebar i {
      font-size: 22px;
      cursor: pointer;
      color: #333;
    }

    /* Main content */
    .main {
      flex: 1;
      padding: 30px 50px;
    }

    h1 {
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 20px;
    }

    /* Top bar */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .search {
      background: #fff;
      border-radius: 20px;
      padding: 8px 15px;
      display: flex;
      align-items: center;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .search input {
      border: none;
      outline: none;
      font-size: 14px;
      padding-left: 8px;
    }

    /* Tabs */
    .tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .tab {
      background: #fde2e4;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 600;
      cursor: pointer;
    }

    .tab:nth-child(2) { background: #f7cad0; }
    .tab:nth-child(3) { background: #fff1b6; }
    .tab:nth-child(4) { background: #e7d5ff; }

    .tab.active {
      background: #000;
      color: #fff;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      background: #f3f8f8;
      border-radius: 12px;
      overflow: hidden;
    }

    th, td {
      padding: 14px 18px;
      text-align: left;
    }

    th {
      background-color: #d9ecec;
      font-size: 14px;
      font-weight: 600;
    }

    td {
      border-top: 1px solid #dcdcdc;
      font-size: 14px;
    }

    .details {
      text-align: right;
      font-weight: bold;
      cursor: pointer;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 6px;
    }

    .pagination button {
      border: 1px solid #ccc;
      background: #f9f9f9;
      border-radius: 6px;
      padding: 6px 10px;
      cursor: pointer;
    }

    .pagination button.active {
      background: #c9e7e5;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <i>🏠</i>
    <i>📊</i>
    <i>📘</i>
    <i>🎓</i>
    <i>⚙️</i>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="top-bar">
      <h1>Grades Overview</h1>
      <div class="search">
        🔍 <input type="text" placeholder="Search assignments">
      </div>
    </div>

    <div class="tabs">
      <div class="tab">Class Name</div>
      <div class="tab">Class Name</div>
      <div class="tab">Class Name</div>
      <div class="tab">Class Name</div>
      <div class="tab active">Class Name ⬇️</div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Assignment Name</th>
          <th>Score</th>
          <th>Feedback</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Assign #1: Ayuku na mag-aral laging...</td>
          <td>100/100</td>
          <td>Nagreklamo i layk...</td>
          <td class="details">⋮</td>
        </tr>
        <tr>
          <td>Assign #1: Ayuku na mag-aral laging...</td>
          <td>100/100</td>
          <td>Nagreklamo i layk...</td>
          <td class="details">⋮</td>
        </tr>
        <tr>
          <td>Assign #1: Ayuku na mag-aral laging...</td>
          <td>100/100</td>
          <td>Nagreklamo i layk...</td>
          <td class="details">⋮</td>
        </tr>
        <tr>
          <td>Assign #1: Ayuku na mag-aral laging...</td>
          <td>100/100</td>
          <td>Nagreklamo i layk...</td>
          <td class="details">⋮</td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button class="active">1</button>
      <button>2</button>
      <button>3</button>
      <button>4</button>
      <button>...</button>
      <button>10</button>
    </div>
  </div>

</body>
</html>