const { $ } = window;

$(() => {
  const grid = new window.prestashop.component.Grid('blog_category');

  grid.addExtension(new window.prestashop.component.GridExtensions.SubmitBulkActionExtension());
  grid.addExtension(new window.prestashop.component.GridExtensions.BulkActionCheckboxExtension());
});