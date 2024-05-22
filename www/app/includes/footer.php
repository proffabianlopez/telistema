</main>
        </div>
    </div>

    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.querySelector('.main-content');
            var navbarBrand = document.querySelector('.navbar-brand');
            sidebar.classList.toggle('collapsed');
            if (sidebar.classList.contains('collapsed')) {
                mainContent.classList.add('expanded');
                navbarBrand.style.marginLeft = '0';
            } else {
                mainContent.classList.remove('expanded');
                navbarBrand.style.marginLeft = '15px';
            }
        });
    </script>


<!-- Boostrap JavaScript -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/all.min.js"></script>
<script src="../js/custom.js"></script>
</body>

</html>