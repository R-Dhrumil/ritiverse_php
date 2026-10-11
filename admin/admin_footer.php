    </div><!-- /.admin-content-wrap -->

    <footer style="padding: 18px 32px; border-top: 1px solid var(--admin-border); font-size: 12px; color: var(--admin-text-muted); display: flex; align-items: center; justify-content: space-between; background: #FFFFFF;">
      <span>RiTiVerse Studio Control Center • cPanel Production Architecture</span>
      <span>PHP <?= phpversion() ?> • MySQL <?= is_db_connected() ? 'Active' : 'Offline' ?></span>
    </footer>
  </main>

</div><!-- /.admin-layout -->

</body>
</html>
