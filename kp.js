$(document).ready(function(){
      $("#searchPanel").hide();
  });
$(document).ready(function(){
    $(".searchButton").click(function(){
      $("#searchPanel").fadeToggle();
    });
  });
  
function goBack() {
  window.history.back();
}

function loadHome(){
  window.location.href="kp_home.php";
}

function loadProductPageOrdinary(idProduct){
  window.location.href="kp_product_page.php?idp="+idProduct+"&type=ordinary";  
}
function loadProductPageOrdinaryAdvanced(idProduct){
  window.location.href="kp_product_page.php?idp="+idProduct+"&type=ordinaryAdv";  
}
function loadProductPageOrdinaryAdmin(idProduct){
  window.location.href="kp_product_page.php?idp="+idProduct+"&type=ordinaryAdmin";  
}
function loadProductPageCustomer(idProduct){
  window.location.href="kp_product_page.php?idp="+idProduct+"&type=customer";  
}
function loadProductPageSellerOwn(idProduct){
  window.location.href="kp_product_page.php?idp="+idProduct+"&type=sellerOwn";  
}



function loadLogInForm() {
  window.location.href="kp_log_in.php";
}

function loadSignUpForm(){
  window.location.href="kp_sign_up.php";
}

function loadProfilePageCustomer(){
  window.location.href="kp_customer_profile.php";
}

function loadProfilePageSeller(){
  window.location.href="kp_seller_profile.php";
}

function loadCustomerPage(){
  window.location.href="kp_customer_page.php";
}

function loadSellerPage(){
  window.location.href="kp_seller_page.php";
}

function loadAdminPage(){
  window.location.href="kp_admin_page.php";
}
function loadAdminPageUsersList(){
  window.location.href="kp_admin_page_users.php";
}
function loadAdminPageAddUser(){
  window.location.href="kp_admin_page_add_user.php";
}

function loadEditPage(){
  window.location.href="kp_edit_product_page.php";
}

function loadCustomerProfileForOthers(idCustomer){
  window.location.href="kp_customer_profile_for_others.php?idc="+idCustomer;
}

function loadSellerProfileForOthers(idSeller){
  window.location.href="kp_seller_profile_for_others.php?ids="+idSeller+"&user=other";
}

function loadSellerProfileForCustomers(idSeller){
  window.location.href="kp_seller_profile_for_others.php?ids="+idSeller+"&user=customer";
}

function loadSellerProfileForAdmin(idSeller){
  window.location.href="kp_seller_profile_for_others.php?ids="+idSeller+"&user=admin";
}




function searchByTitleHome(){
  window.location.href="kp_home_after_search.php?regex="+document.getElementById("yourTitleToSearch").value+"&type=byTitle";
}

function searchByCategoryHome(category){
  window.location.href="kp_home_after_search.php?regex="+category+"&type=byCategory";
}

function searchByPriceHome(){
  window.location.href="kp_home_after_search.php?from="+document.getElementById("priceFrom").value+"&to="+document.getElementById("priceTo").value+"&type=byPrice";
}




function searchByTitleCustomer(){
  window.location.href="kp_customer_page_after_search.php?regex="+document.getElementById("yourTitleToSearch").value+"&type=byTitle";
}

function searchByCategoryCustomer(category){
  window.location.href="kp_customer_page_after_search.php?regex="+category+"&type=byCategory";
}

function searchByPriceCustomer(){
  window.location.href="kp_customer_page_after_search.php?from="+document.getElementById("priceFrom").value+"&to="+document.getElementById("priceTo").value+"&type=byPrice";
}




function searchByTitleSeller(){
  window.location.href="kp_seller_page_after_search.php?regex="+document.getElementById("yourTitleToSearch").value+"&type=byTitle";
}

function searchByCategorySeller(category){
  window.location.href="kp_seller_page_after_search.php?regex="+category+"&type=byCategory";
}

function searchByPriceSeller(){
  window.location.href="kp_seller_page_after_search.php?from="+document.getElementById("priceFrom").value+"&to="+document.getElementById("priceTo").value+"&type=byPrice";
}



function searchByTitleAdmin(){
  window.location.href="kp_admin_page_after_search.php?regex="+document.getElementById("yourTitleToSearch").value+"&type=byTitle";
}

function searchByCategoryAdmin(category){
  window.location.href="kp_admin_page_after_search.php?regex="+category+"&type=byCategory";
}

function searchByPriceAdmin(){
  window.location.href="kp_admin_page_after_search.php?from="+document.getElementById("priceFrom").value+"&to="+document.getElementById("priceTo").value+"&type=byPrice";
}



function openNav() {
  document.getElementById("mySidebar").style.width = "230px";
  document.getElementById("bodyId").style.marginLeft = "230px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("bodyId").style.marginLeft= "0";
}

