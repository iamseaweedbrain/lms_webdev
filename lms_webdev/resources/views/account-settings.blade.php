<x-sidebar title="Account Settings">

    <h2 style="font-size: 1.8rem; font-weight: 600;">Account Settings</h2>

    <div style="display: flex; gap: 60px; margin-top: 30px;">
        {{-- LEFT: Profile Info --}}
        <div style="flex: 1;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="width:80px;height:80px;border-radius:50%;background:#ddd;"></div>
                <div>
                    <h3 style="margin:0;">John Doe</h3>
                    <p style="margin:0;color:#777;">johndoe@email.com</p>
                </div>
            </div>

            <div style="margin-top: 40px; border: 2px solid pink; padding: 20px; border-radius: 12px; width: 380px;">
                <p><strong>Contact Number:</strong><br>09123456789</p>
                <p><strong>Birthdate:</strong><br>Nov. 1, 2025</p>
                <p><strong>Address:</strong><br>Phase 1 Package 1 Bagong Silang, Caloocan City</p>
            </div>
        </div>

        {{-- RIGHT: Notifications --}}
        <div style="flex: 1;">
            <h3 style="margin-bottom: 10px;">Notifications</h3>
            <ul style="list-style:none;padding:0;line-height:1.8;">
                <li>Comments <input type="checkbox" checked></li>
                <li>Private comments on work <input type="checkbox" checked></li>
                <li>Returned work from teachers <input type="checkbox" checked></li>
                <li>Due-date reminders <input type="checkbox" checked></li>
            </ul>

            <button style="margin-top: 25px; background: #000; color: #fff; padding: 10px 20px; border-radius: 10px; border: none;">Change Password</button>
            <button style="margin-top: 10px; background: #ff6b6b; color: #fff; padding: 10px 20px; border-radius: 10px; border: none;">Log Out</button>
        </div>
    </div>

</x-sidebar>
