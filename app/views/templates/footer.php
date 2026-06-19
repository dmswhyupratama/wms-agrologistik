<?php if( !isset($_SESSION['id_user']) || $_SESSION['role'] == 'pemasok' ) : ?>
    </div> <?php else : ?>
            </main> </div> </div> <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById('sidebarDesktop');
        const toggleBtn = document.getElementById('sidebarToggle');
        
        // --- 1. Sidebar Toggle Logic ---
        if (sidebar && toggleBtn) {
            // Toggle sidebar on click
            toggleBtn.addEventListener('click', function() {
                document.documentElement.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', document.documentElement.classList.contains('sidebar-collapsed'));
            });
        }

        // --- 2. Remember Scroll Position ---
        if (sidebar) {
            const scrollKey = 'sidebarScrollPos';
            const savedPos = sessionStorage.getItem(scrollKey);
            if (savedPos !== null) {
                // Restore scroll without animation
                sidebar.scrollTop = parseInt(savedPos, 10);
            }
            
            // Save scroll position
            sidebar.addEventListener('scroll', function() {
                sessionStorage.setItem(scrollKey, sidebar.scrollTop);
            });
        }
    });
    </script>
</body>
</html>